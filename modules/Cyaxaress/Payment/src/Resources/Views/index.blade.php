@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('payments.index') }}" title="Transactions">Transactions</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>Total sales of the last 30 days on the site</p>
            <p>{{ number_format($last30DaysTotal) }} ₹</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>Net income of the last 30 days on the site</p>
            <p>{{ number_format($last30DaysBenefit) }} ₹</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>Total sales of the site</p>
            <p>{{ number_format($totalSell) }} ₹</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
            <p>Total net income of the site</p>
            <p>{{ number_format($totalBenefit) }} ₹</p>
        </div>
    </div>
    <div class="row no-gutters border-radius-3 font-size-13">
        <div class="col-12 bg-white padding-30 margin-bottom-20">
            <div id="container"></div>
        </div>
    </div>
    <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
        <p class="margin-bottom-15">All Transactions</p>
        <div class="t-header-search">
            <form action="">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box font-size-13" placeholder="Search transactions">
                    <div class="t-header-search-content">
                        <input type="text"  class="text" name="email" value="{{ request("email") }}"  placeholder="Email">
                        <input type="text"  class="text" name="amount"  value="{{ request("amount") }}" placeholder="Amount in ₹">
                        <input type="text"  class="text" name="invoice_id" value="{{ request("invoice_id") }}" placeholder="Invoice Number">
                        <input type="text"  class="text" name="start_date" value="{{ request("start_date") }}" placeholder="From Date: dd-mm-yyyy">
                        <input type="text" class="text margin-bottom-20" name="end_date" value="{{ request("end_date") }}"  placeholder="To Date: dd-mm-yyyy">
                        <button type="submit" class="btn btn-webamooz_net">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
        <p class="box__title">Transactions</p>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>ID</th>
                    <th>Transaction Number</th>
                    <th>Full Name</th>
                    <th>Payee Email</th>
                    <th>Amount (₹)</th>
                    <th>Instructor's Income</th>
                    <th>Site Income</th>
                    <th>Course Name</th>
                    <th>Date and Time</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr role="row" class="">
                        <td><a href="">{{ $payment->id }}</a></td>
                        <td>{{ $payment->invoice_id }}</td>
                        <td>{{ $payment->buyer->name }}</td>
                        <td>{{ $payment->buyer->email }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->seller_share }}</td>
                        <td>{{ $payment->site_share }}</td>
                        <td>{{ $payment->paymentable->title }}</td>

                        <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d-m-Y H:i:s') }}</td>
                        <td class="@if($payment->status == \Cyaxaress\Payment\Models\Payment::STATUS_SUCCESS) text-success @else text-error @endif">@lang($payment->status)</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        @include('Common::layouts.feedbacks')
    </script>
    @include("Payment::chart")
@endsection
