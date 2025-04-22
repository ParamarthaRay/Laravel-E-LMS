@extends('User::Front.master')

@section('content')
<form action="" class="form" method="post">
    <a class="account-logo" href="/">
        <img src="img/Hemn_ORG.png" class="w-100" alt="">
    </a>
    <div class="form-content form-account">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" class="txt txt-l @error('name') is-invalid @enderror" placeholder="Full Name *"
                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
            >
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input id="email" type="email" class="txt txt-l @error('email') is-invalid @enderror" placeholder="Email *"
                   name="email" value="{{ old('email') }}" required autocomplete="email"
            >
            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror

            <input id="mobile" type="text" class="txt txt-l @error('mobile') is-invalid @enderror" placeholder="Mobile"
                   name="mobile" value="{{ old('mobile') }}" autocomplete="mobile"
            >
            @error('mobile')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror


            <input id="password" type="password" class="txt txt-l @error('password') is-invalid @enderror"
                   placeholder="Password *"
                   name="password" required autocomplete="new-password"
            >
            <input  id="password-confirm" type="password" class="txt txt-l @error('password') is-invalid @enderror"
                    placeholder="Confirm Password *"
                    name="password_confirmation" required autocomplete="new-password"
            >
            <span class="rules">Password must be at least 6 characters long and contain a mix of uppercase and lowercase letters, numbers, and non-alphabetical characters such as !@#$%^&*().</span>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <br>
            <button class="btn continue-btn">Register and Continue</button>
        </form>
        <div class="form-footer">
            <a href="{{ route('login') }}">Login Page</a>
        </div>
    </div>

</form>
@endsection
