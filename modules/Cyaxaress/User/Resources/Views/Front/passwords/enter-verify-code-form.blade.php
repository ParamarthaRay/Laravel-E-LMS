@extends('User::Front.master')

@section('content')
    <div class="account act">
        <form action="{{ route('password.checkVerifyCode') }}" class="form" method="post">
            @csrf
            <input type="hidden" name="email" value="{{ request()->email }}">
            <a class="account-logo" href="/">
                <img src="/img/Hemn_ORG.png" alt="">
            </a>
            <div class="card-header">
                <p class="activation-code-title">Enter the code sent to the email <span>{{ request()->email }}</span>
                    . The email may have been sent to the spam folder.
                </p>
            </div>
            <div class="form-content form-content1">
                <input name="verify_code" required class="activation-code-input" placeholder="Activation Code">
                @error('verify_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <br>
                <button class="btn i-t">Confirm</button>
                <a href="{{ route("password.sendVerifyCodeEmail") }}?email={{ request("email") }}">Resend activation code</a>

            </div>
            <div class="form-footer">
                <a href="{{ route('register') }}">Registration Page</a>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>
@endsection
