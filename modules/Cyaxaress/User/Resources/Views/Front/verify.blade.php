@extends('User::Front.master')

@section('content')
    <div class="account act">
        <form action="{{ route('verification.verify') }}" class="form" method="post">
            @csrf
            <a class="account-logo" href="/">
                <img src="/img/Hemn_ORG.png" alt="">
            </a>
            <div class="card-header">
                <p class="activation-code-title">Enter the code sent to the email <span>{{ auth()->user()->email }}</span>
                    . The email might have been sent to the spam folder. 
                    Did you enter your email incorrectly? <a href="{{ route('users.profile') }}">Click here to edit your email.</a>
                </p>
            </div>
            <div class="form-content form-content1">
                <input name="verify_code" required class="activation-code-input" placeholder="Activate">
                @error('verify_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <br>
                <button class="btn i-t">Confirm</button>
                <a href="#" onclick="
                event.preventDefault();
                document.getElementById('resend-code').submit()
                ">Resend Activation Code</a>
            </div>
            <div class="form-footer">
                <a href="{{ route('register') }}">Registration Page</a>
            </div>
        </form>

        <form id="resend-code" action="{{ route('verification.resend') }}" method="post">
            @csrf
        </form>
    </div>
@endsection

@section('js')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>
@endsection
