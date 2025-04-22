@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('users.index') }}" title="Users">Users</a></li>
@endsection

@section('content')
    <div class="row no-gutters">

        {{-- User Account Info --}}
        <div class="col-12 border-radius-3 bg-white margin-bottom-10">
            <p class="box__title">Full account information for <strong>{{ $user->name }}</strong></p>
            <div class="w-100 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <ul>
                    <li>Email: <strong><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></strong></li>
                    <li>Username: <strong>{{ $user->username }}</strong></li>
                    <li>Mobile: <strong>{{ $user->mobile }}</strong></li>
                    <li>Title: <strong>{{ $user->headline }}</strong></li>
                    <li>Bio: <strong>{{ $user->bio }}</strong></li>
                    <li>Account Balance: <strong>{{ $user->balance }}</strong></li>
                    <li>Email Verified At: <strong>{{ $user->email_verified_at ? $user->email_verified_at->format('d-m-Y') : "Not Verified" }}</strong></li>
                </ul>
            </div>
        </div>

        {{-- Purchased Courses --}}
        <div class="col-6 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p class="box__title">Purchased Courses</p>
            <div class="table__box">
                <table class="table">
                    <thead>
                        <tr class="title-row">
                            <th>ID</th>
                            <th>Course</th>
                            <th>Amount Paid</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->id }}</td>
                                <td><a href="{{ $purchase->path() }}">{{ $purchase->title }}</a></td>
                                <td>{{ $purchase->payment()->amount }}</td>
                                <td>{{ $purchase->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Teaching Courses --}}
        <div class="col-6 border-radius-3 bg-white margin-bottom-10">
            <p class="box__title">Courses Being Taught</p>
            <div class="table__box">
                <table class="table">
                    <thead>
                        <tr class="title-row">
                            <th>ID</th>
                            <th>Course Title</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->courses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td><a href="{{ $course->path() }}">{{ $course->title }}</a></td>
                                <td>@lang($course->status)</td>
                                <td>{{ $course->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Payments --}}
        <div class="col-6 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p class="box__title">Payments</p>
            <div class="table__box">
                <table class="table">
                    <thead>
                        <tr class="title-row">
                            <th>ID</th>
                            <th>Product</th>
                            <th>Payment Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td><a href="{{ $payment->paymentable->path() }}">{{ $payment->paymentable->title }}</a></td>
                                <td>{{ $payment->amount }}</td>
                                <td>@lang($payment->status)</td>
                                <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Settlement Requests --}}
        <div class="col-6 border-radius-3 bg-white margin-bottom-10">
            <p class="box__title">Settlement Requests</p>
            <div class="table__box">
                <table class="table">
                    <thead>
                        <tr class="title-row">
                            <th>ID</th>
                            <th>Payment Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->settlements as $settlement)
                            <tr>
                                <td>{{ $settlement->id }}</td>
                                <td>{{ $settlement->amount }}</td>
                                <td>@lang($settlement->status)</td>
                                <td>{{ $settlement->created_at->format('d-m-Y') }}</td>
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
@endsection
