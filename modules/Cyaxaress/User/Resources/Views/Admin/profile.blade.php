@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('users.index') }}" title="Users">Users</a></li>
    <li><a href="#" title="Edit User">Edit Profile</a></li>
@endsection

@section('content')
    <div class="row no-gutters margin-bottom-20">
        <div class="col-12 bg-white">
            <p class="box__title">Update Profile</p>

            <x-user-photo />

            <form action="{{ route('users.profile')}}" class="padding-30" method="post">
                @csrf

                <x-input name="name" placeholder="Username" type="text" value="{{ auth()->user()->name }}" required />
                <x-input type="text" name="email" placeholder="Email" value="{{ auth()->user()->email }}" class="text-left" required />
                <x-input type="text" name="mobile" placeholder="Mobile" value="{{ auth()->user()->mobile }}" class="text-left" />
                <x-input type="password" name="password" placeholder="New Password" />

                <p class="rules">
                    Password must be at least 6 characters and a combination of uppercase letters, lowercase letters, numbers, and special characters such as <strong>!@#$%^&amp;*()</strong>.
                </p>

                @can(\Cyaxaress\RolePermissions\Models\Permission::PERMISSION_TEACH)
                    <x-input type="text" name="card_number" placeholder="Bank Card Number" value="{{ auth()->user()->card_number }}" class="text-left" />
                    <x-input type="text" name="shaba" placeholder="Bank Number" value="{{ auth()->user()->shaba }}" class="text-left" />
                    <x-input type="text" name="username" placeholder="Profile Username/Address" value="{{ auth()->user()->username }}" class="text-left" />
                    <x-input type="text" name="telegram" placeholder="Your Telegram ID for receiving notifications" value="{{ auth()->user()->telegram }}" class="text-left" />

                    <p class="input-help text-left margin-bottom-12" dir="ltr">
                        <a href="{{ auth()->user()->profilePath() }}">{{ auth()->user()->profilePath() }}</a>
                    </p>

                    <x-input type="text" name="headline" placeholder="Title" value="{{ auth()->user()->headline }}" />
                    <x-text-area placeholder="Bio" name="bio" value="{{ auth()->user()->bio }}" />
                @endcan

                <br>
                <button class="btn btn-webamooz_net">Update Profile</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=12"></script>
    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection
