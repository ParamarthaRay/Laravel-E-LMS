@extends('User::Front.master')

@section('content')
    <form action="{{ route('login') }}" class="form" method="post">
        @csrf
        <a class="account-logo" href="/">
            <img src="/img/Hemn_ORG.png" alt="">
        </a>
        <div class="form-content form-account">

            <input id="email" type="text" class="txt-l txt @error('email') is-invalid @enderror" name="email"
             placeholder="Email or Mobile Number" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input  id="password" type="password" class="txt-l txt" placeholder="Password"
                   name="password" required autocomplete="current-password"
            >
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <br>
            <button class="btn btn--login">Login</button>
            <label class="ui-checkbox">
                Remember me
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkmark"></span>
            </label>
            <div class="recover-password">
                <a href="{{ route('password.request') }}">Recover Password</a>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('register') }}">Register</a>
        </div>
    </form>
@endsection
