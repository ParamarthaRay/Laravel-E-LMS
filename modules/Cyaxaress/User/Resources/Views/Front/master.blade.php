<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css?v={{ uniqid() }}">
    <link rel="stylesheet" href="/css/font/font.css">
    <title>Registration Page</title>
</head>
<body>
<main>

    <div class="account">
        @yield('content')
    </div>
</main>
@yield('js')
</body>
</html>
