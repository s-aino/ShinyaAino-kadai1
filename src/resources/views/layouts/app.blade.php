<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'FashionablyLate')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <header class="site-header">
        <div class="inner">
            <div class="brand"><a href="{{ url('/') }}">FashionablyLate</a></div>
            <nav class="actions">
                @yield('header_action')
            </nav>
        </div>
    </header>


    @yield('content')

</body>

</html>