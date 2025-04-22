@extends('Dashboard::master')

@section('content')
    @can(\Cyaxaress\RolePermissions\Models\Permission::PERMISSION_TEACH)
        <div class="row no-gutters font-size-13 margin-bottom-10">
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>Current Account Balance</p>
                <p>{{ number_format(auth()->user()->balance) }} ₹</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>Total Course Sales</p>
                <p>{{ number_format($totalSales) }} ₹</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>Deducted Commission</p>
                <p>{{ number_format($totalSiteShare) }} ₹</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
                <p>Net Income</p>
                <p>{{ number_format($totalBenefit) }} ₹</p>
            </div>
        </div>

        <div class="row no-gutters font-size-13 margin-bottom-10">
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>Today's Income</p>
                <p>{{ number_format($todayBenefit) }} ₹</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>Income (Last 30 Days)</p>
                <p>{{ number_format($last30DaysBenefit) }} ₹</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>Pending Settlements</p>
                <p>0 ₹</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
                <p>Successful Transactions Today ({{ $todaySuccessPaymentsCount }})</p>
                <p>{{ number_format($todaySuccessPaymentsTotal) }} ₹</p>
            </div>
        </div>

        <div class="row no-gutters font-size-13 margin-bottom-10">
            <div class="col-8 padding-20 bg-white margin-bottom-10 margin-left-10 border-radius-3">
                <div class="col-12 bg-white padding-30 margin-bottom-20">
                    <div id="container"></div>
                </div>
            </div>
            <div class="col-4 info-amount padding-20 bg-white margin-bottom-12-p margin-bottom-10 border-radius-3">
                <p class="title icon-outline-receipt">Withdrawable Balance</p>
                <p class="amount-show color-444">
                    {{ number_format(auth()->user()->balance) }}<span> ₹</span>
                </p>
                <p class="title icon-sync">Being Settled</p>
                <p class="amount-show color-444">0<span> ₹</span></p>
                <a href="/" class="all-reconcile-text color-2b4a83">All Settlements</a>
            </div>
        </div>
    @endcan

    <div class="row bg-white no-gutters font-size-13">
        <div class="title__row">
            <p>Your Recent Transactions</p>
            <a class="all-reconcile-text margin-left-20 color-2b4a83">View All Transactions</a>
        </div>
        <div class="table__box">
            <table width="100%" class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>Payment ID</th>
                    <th>Payer Email</th>
                    <th>Amount (₹)</th>
                    <th>Your Income</th>
                    <th>Site Commission</th>
                    <th>Course Title</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr role="row">
                        <td>{{ $payment->invoice_id }}</td>
                        <td>{{ $payment->buyer->email }}</td>
                        <td>{{ number_format($payment->amount) }}</td>
                        <td>{{ number_format($payment->seller_share) }}</td>
                        <td>{{ number_format($payment->site_share) }}</td>
                        <td>{{ $payment->paymentable->title }}</td>
                        <td>{{ $payment->created_at->format('Y-m-d h:i A') }}</td>
                        <td class="@if($payment->status == \Cyaxaress\Payment\Models\Payment::STATUS_SUCCESS) text-success @else text-error @endif">
                            @lang("payment." . $payment->status)
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("js")
    @include("Payment::chart")
@endsection
