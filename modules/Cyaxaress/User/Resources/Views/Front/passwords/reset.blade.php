@extends('User::Front.master')

@section('content')
    <form method="POST" class="form" action="{{ route('password.update') }}">
        <a class="account-logo" href="/">
            <img src="/img/Hemn_ORG.png" alt="">
        </a>
        <div class="form-content form-account">
          @csrf
            <input id="password" type="password" class="txt txt-l @error('password') is-invalid @enderror"
                   placeholder="New Password *"
                   name="password" required autocomplete="new-password"
            >
            <input id="password-confirm" type="password" class="txt txt-l @error('password') is-invalid @enderror"
                   placeholder="Confirm New Password *"
                   name="password_confirmation" required autocomplete="new-password"
            >
            <span class="rules">The password must be at least 6 characters long and a combination of uppercase, lowercase letters, numbers, and non-alphabetic characters such as !@#$%^&*().</span>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br>
            <button class="btn continue-btn">Update Password</button>
        </div>
    </form>
@endsection
