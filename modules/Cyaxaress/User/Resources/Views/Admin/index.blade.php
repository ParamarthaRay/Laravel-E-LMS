@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('users.index') }}" title="Users">Users</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">Users</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>User Role</th>
                        <th>Registration Date</th>
                        <th>IP Address</th>
                        <th>Account Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr role="row">
                        <td><a href="">{{ $user->id }}</a></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>
                            <ul>
                                @foreach($user->roles as $userRole)
                                    <li class="deleteable-list-item">@lang($userRole->name)</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->ip }}</td>
                        <td class="confirmation_status">
                            {!! $user->hasVerifiedEmail() 
                                ? "<span class='text-success'>Verified</span>" 
                                : "<span class='text-error'>Not Verified</span>" 
                            !!}
                        </td>
                        <td>
                            <a href="" onclick="deleteItem(event, '{{ route('users.destroy', $user->id) }}')" class="item-delete mlg-15" title="Delete"></a>
                            <a href="{{ route('users.edit', $user->id) }}" class="item-edit mlg-15" title="Edit"></a>
                            <a href="" onclick="updateConfirmationStatus(event, '{{ route('users.manualVerify', $user->id) }}',
                                'Are you sure you want to verify this item?' , 'Verified')" 
                                class="item-confirm mlg-15" title="Verify"></a>
                        </td>
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
