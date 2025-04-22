@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('settlements.index') }}" title="Settlements">Settlements</a></li>
@endsection

@section('content')
    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="?">All Settlements</a>
                <a class="tab__item" href="?status={{ \Cyaxaress\Payment\Models\Settlement::STATUS_SETTLED }}">Settled Payments</a>
                <a class="tab__item" href="{{ route("settlements.create") }}">New Settlement Request</a>
            </div>
        </div>
        
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="Search in Settlements">
                        <div class="t-header-search-content">
                            <input type="text" class="text" placeholder="Card Number">
                            <input type="text" class="text" placeholder="Number">
                            <input type="text" class="text" placeholder="Date">
                            <input type="text" class="text" placeholder="Email">
                            <input type="text" class="text margin-bottom-20" placeholder="Full Name">
                            <button class="btn btn-webamooz_net">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>Settlement ID</th>
                        <th>User</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Destination Card Number</th>
                        <th>Deposit Request Date</th>
                        <th>Deposit Date</th>
                        <th>Amount (₹)</th>
                        <th>Status</th>
                        @can(\Cyaxaress\RolePermissions\Models\Permission::PERMISSION_MANAGE_SETTLEMENTS)
                            <th>Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($settlements as $settlement)
                    <tr role="row">
                        <td><a href="">{{ $settlement->transaction_id ?? "-" }}</a></td>
                        <td><a href="{{ route('users.info', $settlement->user_id) }}">{{ $settlement->user->name }}</a></td>
                        <td><a href="">{{ $settlement->from ? $settlement->from["name"] : "-" }}</a></td>
                        <td><a href="">{{ $settlement->to ? $settlement->to["name"] : "-" }}</a></td>
                        <td><a href="">{{ $settlement->to ? $settlement->to["cart"] : "-" }}</a></td>
                        <td><a href="">{{ $settlement->created_at->diffForHumans() }}</a></td>
                        <td><a href="">{{ $settlement->settled_at ? $settlement->settled_at->diffForHumans() : "-" }}</a></td>
                        <td><a href="">{{ $settlement->amount }}</a></td>
                        <td><a href="" class="{{ $settlement->getStatusCssClass()}}">@lang($settlement->status)</a></td>

                        @can(\Cyaxaress\RolePermissions\Models\Permission::PERMISSION_MANAGE_SETTLEMENTS)
                        <td>
                            <a href="{{ route("settlements.edit", $settlement->id) }}" class="item-edit" title="Edit"></a>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
