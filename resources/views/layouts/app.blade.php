<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="./img/logo-laravel-facebook.svg" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style')
    <style>
        button>.svg-search>path {
            fill: #385898;
            transition: all 0.5s ease;
        }

        button>.svg-search>path:hover {
            fill: #385898;
        }

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background:#385898; padding:0.25rem;">
            <div class="container">
                <a class="navbar-brand p-0 m-0" href="{{ url('home') }}">
                    <img class="m-0" src="/img/logo-laravel-facebook.svg" alt="Logo Laravel Facebook" width="50"
                        height="50">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto pl-2">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher"
                                aria-label="Search">
                            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit"><svg class="svg-search"
                                    width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
                                </svg></button>
                        </form>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown d-flex">
                            <a href="{{ route('profil', Auth::user()->id) }}"
                                class="text-decoration-none text-white m-auto d-flex">
                                <div class="mr-2" style="width:40px;"><img class="m-auto"
                                        style="width:40px; border-radius:50%; border:1px solid #DADDE1;"
                                        src="{{Auth::user()->getAvatar()}}" width="100%" height="100%">
                                </div>
                                <p class="my-auto"
                                    style="font-family: system-ui, -apple-system, BlinkMacSystemFont, '.SFNSText-Regular', sans-serif; font-weight:bold;">
                                    {{ Auth::user()->firstname }}
                                </p>
                            </a>
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('profil', Auth::user()->id) }}">Profil</a>
                                <a class="dropdown-item" href="{{ route('account') }}">Compte</a>
                                <div class="m-2">
                                    <hr>
                                </div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Se déconnecter') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
