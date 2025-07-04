@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('settlements.index') }}" title="Settlements">Settlements</a></li>
    <li><a href="#" title="Edit Settlement Request">Edit Settlement Request</a></li>
@endsection

@section('content')
    <div class="main-content">
        <form action="{{ route("settlements.update", $settlement->id) }}" method="post" class="padding-30 bg-white font-size-14">
            @csrf
            @method("patch")

            <x-input name="from[name]" value='{{ is_array($settlement->from) && array_key_exists("name", $settlement->from) ? $settlement->from["name"] : "" }}' type="text" placeholder="Sender Account Holder Name" />
            <x-input name="from[cart]" value='{{ is_array($settlement->from) && array_key_exists("cart", $settlement->from) ? $settlement->from["cart"] : "" }}' type="text" placeholder="Sender Card Number" />

            <x-input name="to[name]" value='{{ is_array($settlement->to) && array_key_exists("name", $settlement->to) ? $settlement->to["name"] : "" }}' type="text" placeholder="Recipient Account Holder Name" required />
            <x-input name="to[cart]" value='{{ is_array($settlement->to) && array_key_exists("cart", $settlement->to) ? $settlement->to["cart"] : "" }}' type="text" placeholder="Recipient Card Number" required />

            <x-input name="amount" value="{{ $settlement->amount }}" readonly type="text" placeholder="Amount (in ₹)" required />

            <x-select name="status">
                @foreach(\Cyaxaress\Payment\Models\Settlement::$statues as $status)
                    <option value="{{ $status }}" {{ $settlement->status == $status ? "selected" : "" }}>@lang($status)</option>
                @endforeach
            </x-select>

            <div class="row no-gutters border-2 margin-bottom-15 text-center">
                <div class="w-50 padding-20">Remaining Balance:</div>
                <div class="bg-fafafa padding-20 w-50">{{ number_format($settlement->user->balance) }} ₹</div>
            </div>

            <button type="submit" class="btn btn-webamooz_net">Update</button>
        </form>
    </div>
@endsection
