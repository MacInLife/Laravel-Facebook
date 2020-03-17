## III - Modification de la page de connexion

Transformation de la page d'accueil de LARAVEL en une page de connexion similaire à celle de Facebook.

1. Pour cela, il faut modifier le fichier **"welcome.blade.php"**<br>
   Il se situe dans le dossier ./ressources/views

<details>
<summary>
Code de la page welcome.blade.php
</summary>

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Facebook</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .left,
        .right {
            width: 50%;
            justify-content: center;
        }

    </style>

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background:#385898;">
        <div class="container">
            <a style="font-size:1.5rem;" class="navbar-brand text-white" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}<img class="pl-2 mb-1" src="img/facebook.png" alt="" width="120">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <form method="POST" action="{{ route('login') }}" class="d-flex">
                        @csrf

                        <div class="form-group px-2 m-0">
                            <label style="font-size:12px;" for="email"
                                class="text-md-right text-white mb-0">{{ __('Adresse e-mail') }}</label>

                            <div class="">
                                <input style="font-size:12px;" id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group px-2 m-0">
                            <label style="font-size:12px;" for="password"
                                class="text-md-right text-white mb-0">{{ __('Mot de passe') }}</label>

                            <div class="">
                                <input style="font-size:12px;" id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                @if (Route::has('password.request'))
                                <a style="color:#9cb4d8; font-size:12px;" class="btn btn-link"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group m-auto">
                            <div class="offset-md-2 pb-1">
                                <button style="font-size:12px;" type="submit" class="btn btn-primary">
                                    {{ __('Connexion') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex flex-nowrap">
        <div class="left m-2">
            <H1
                style="color:#0e385f; font-size: 20px; font-weight: bold; line-height: 29px;
    margin-top: 40px; width: 450px; word-spacing: -1px; font-family: system-ui, -apple-system, BlinkMacSystemFont, '.SFNSText-Regular', sans-serif;">
                Avec Facebook, partagez et restez en contact avec votre entourage</H1>
            <div>
                <img src="img/ObaVg52wtTZ.png" alt="" width="437">
            </div>
        </div>
        <div class="row right d-flex justify-content-center m-2 ">

            <H1 class="row"
                style="  margin-top: 40px; font-family: system-ui, -apple-system, BlinkMacSystemFont, '.SFNSText-Regular', sans-serif;">
                {{ __('Inscription') }}</H1>

            <div class="col-md-10">
                <p>C’est rapide et facile.</p>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <!-- Champ Prénom -->
                        <div class="form-group row mr-5">
                            <input id="firstname" type="text"
                                class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                value="{{ old('firstname') }}" placeholder="Prénom" required autocomplete="firstname"
                                autofocus>

                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Champ Nom -->
                        <div class="form-group row">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" placeholder="Nom de famille" required
                                autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Champ Mail -->
                    <div class="form-group row">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Adresse e-mail" required
                            autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="form-group row">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="Mot de passe" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Champ Mot de passe de confirmation -->
                    <div class="form-group row">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            placeholder="Mot de passe de confirmation" required autocomplete="new-password">
                    </div>

                    <!-- Bouton d'envoi du formulaire d'inscription -->
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-success">
                                {{ __('Inscription') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
```

</details>

Visuel de la page de connexion :
![FB-welcome.png](FB-welcome.png)
