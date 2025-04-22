@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('settlements.index') }}" title="Settlements">Settlements</a></li>
    <li><a href="#" title="New Settlement Request">New Settlement Request</a></li>
@endsection

@section('content')
    <div class="main-content">
        <form action="{{ route("settlements.store") }}" method="post" class="padding-30 bg-white font-size-14">
            @csrf
            <x-input name="name" type="text" placeholder="Account Holder Name" required />
            <x-input name="cart" type="text" placeholder="Card Number" required />
            <x-input name="amount" value="{{ auth()->user()->balance }}" type="text" placeholder="Amount (in ₹)" required />

            <div class="row no-gutters border-2 margin-bottom-15 text-center">
                <div class="w-50 padding-20">Withdrawable Balance:</div>
                <div class="bg-fafafa padding-20 w-50">{{ number_format(auth()->user()->balance) }} ₹</div>
            </div>

            <div class="row no-gutters border-2 text-center margin-bottom-15">
                <div class="w-50 padding-20">Maximum Deposit Time:</div>
                <div class="w-50 bg-fafafa padding-20">3 days</div>
            </div>

            <button type="submit" class="btn btn-webamooz_net">Submit Settlement Request</button>
        </form>
    </div>
@endsection
