<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield(section: 'title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">

    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="{{ asset('asset/css/Control.Geocoder.css') }}" />
    @yield('styles')
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">Heroes App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('welcome') }}">Home</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('news') }}">News</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('safetyguide') }}">Safety
                            Guide</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('aboutus') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('contact') }}">Contact</a>
                    </li>

                </ul>
                <ul class="navbar-nav flex">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->profile && Auth::user()->profile->firstname)
                                    {{ Auth::user()->profile->firstname }}
                                @else
                                    {{ Auth::user()->name ?? 'User' }}
                                @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->role->name === 'user')
                                    @if (Auth::user()->agency->name === 'DEFAULT')
                                        <li><a class="dropdown-item" href="{{ url('/') }}">User Dashboard</a></li>
                                    @endif
                                @elseif(Auth::user()->role->name === 'admin')
                                    @if (Auth::user()->agency->name === 'PNP')
                                        <li><a class="dropdown-item" href="{{ url('/admin/pnp-dashboard') }}">PNP
                                                Dashboard</a></li>
                                    @elseif(Auth::user()->agency->name === 'BFP')
                                        <li><a class="dropdown-item" href="{{ url('/admin/bfp-dashboard') }}">BFP
                                                Dashboard</a></li>
                                    @elseif(Auth::user()->agency->name === 'MDRRMO')
                                        <li><a class="dropdown-item" href="{{ url('/admin/mdrrmo-dashboard') }}">MDRRMO
                                                Dashboard</a></li>
                                    @elseif(Auth::user()->agency->name === 'MHO')
                                        <li><a class="dropdown-item" href="{{ url('/admin/mho-dashboard') }}">MHO
                                                Dashboard</a></li>
                                    @elseif(Auth::user()->agency->name === 'COAST GUARD')
                                        <li><a class="dropdown-item" href="{{ url('/admin/coast-guard-dashboard') }}">Coast
                                                Guard Dashboard</a></li>
                                    @elseif(Auth::user()->agency->name === 'LGU')
                                        <li><a class="dropdown-item" href="{{ url('/admin/lgu-dashboard') }}">LGU
                                                Dashboard</a></li>
                                    @else
                                        <li><a class="dropdown-item" href="{{ url('/') }}">Default Dashboard</a></li>
                                    @endif
                                @elseif(Auth::user()->role->name === 'super admin')
                                    <li><a class="dropdown-item" href="{{ url('/super-admin/dashboard') }}">Super Admin
                                            Dashboard</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ url('/') }}">Dashboard (Role:
                                            {{ Auth::user()->role ?? 'None' }})</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link active">
                                Log in
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link active">
                                    Register
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

            </div>
        </div>
    </nav>

    @yield('content')




    <!--scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!--leaflet-->
    <script src="{{ asset('asset/js/leaflet.js') }}" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script src="{{ asset('asset/js/Control.Geocoder.js') }}"></script>

    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--sweetalert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')

</body>

</html>
