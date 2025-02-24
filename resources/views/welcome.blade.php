<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->

</head>

<body>
    @if (Route::has('login'))
        <nav class="-mx-3 flex flex-1 justify-end">
            @auth
                <a href="{{ url('user/dashboard') }}">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</body>

</html>
