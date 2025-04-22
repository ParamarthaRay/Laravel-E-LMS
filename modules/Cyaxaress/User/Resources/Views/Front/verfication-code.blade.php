@extends('User::Front.master')

@section('content')
    <form action="" class="form" method="post">
        <a class="account-logo" href="index.html">
            <img src="/img/Hemn_ORG.png" alt="">
        </a>
        <div class="card-header">
            <p class="activation-code-title">Enter the code sent to the email <span>Ayushniko3@gmail.com</span></p>
        </div>
        <div class="form-content form-content1">
            <input class="activation-code-input" placeholder="Activate">
            <br>
            <button class="btn i-t">Confirm</button>

        </div>
        <div class="form-footer">
            <a href="login.html">Registration Page</a>
        </div>
    </form>
@endsection
