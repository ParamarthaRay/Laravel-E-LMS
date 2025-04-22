<?php

namespace Cyaxaress\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cyaxaress\Payment\Events\PaymentWasSuccessful;
use Cyaxaress\Payment\Gateways\Gateway;
use Cyaxaress\Payment\Models\Payment;
use Cyaxaress\Payment\Repositories\PaymentRepo;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(PaymentRepo $paymentRepo, Request $request)
    {
        $this->authorize('manage', Payment::class);

        // Use Carbon to format the start and end dates in d-m-Y format
        $startDate = $request->start_date ? Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay() : null;
        $endDate = $request->end_date ? Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay() : null;

        $payments = $paymentRepo
            ->searchEmail($request->email)
            ->searchAmount($request->amount)
            ->searchInvoiceId($request->invoice_id)
            ->searchAfterDate($startDate)
            ->searchBeforeDate($endDate)
            ->paginate();

        $last30DaysTotal = $paymentRepo->getLastNDaysTotal(-30);
        $last30DaysBenefit = $paymentRepo->getLastNDaysSiteBenefit(-30);
        $last30DaysSellerShare = $paymentRepo->getLastNDaysSellerShare(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();
        $totalBenefit = $paymentRepo->getLastNDaysSiteBenefit();

        // Get daily summary for the last 30 days
        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(Carbon::now()->addDays($i)->format('Y-m-d'), 0);
        }

        $summery = $paymentRepo->getDailySummery($dates);

        return view('Payment::index', compact(
            'payments',
            'last30DaysTotal',
            'last30DaysBenefit',
            'totalSell',
            'totalBenefit',
            'last30DaysSellerShare',
            'summery',
            'dates'
        ));
    }

    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));

        if (! $payment) {
            newFeedback('Transaction Failed', 'The requested transaction was not found!', 'error');

            return redirect('/');
        }

        $result = $gateway->verify($payment);

        if (is_array($result)) {
            newFeedback('Operation Failed', $result['message'], 'error');
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_FAIL);
            // TODO: Handle additional failure logging or action
        } else {
            event(new PaymentWasSuccessful($payment));
            newFeedback('Operation Successful', 'Payment completed successfully.', 'success');
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);
        }

        return redirect()->to($payment->paymentable->path());
    }

    public function purchases()
    {
        $payments = auth()->user()->payments()->with('paymentable')->paginate();

        return view('Payment::purchases', compact('payments'));
    }
}
