@extends('layouts.app')
<title>Laravel Facebook - Compte</title>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            <div class="card mb-2">
                <div class="card-header">Gestion du compte</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('account.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Changement d'état de l'avatar de base à l'upload -->
                        <div class="mx-auto mb-2" style="width:80px; height:80px;"><img id="user-avatar"
                                class="m-auto rounded img-thumbnail" src="{{Auth::user()->getAvatar()}}" width="100%"
                                height="100%">
                        </div>

                        <!-- Ajout de l'avatar -->
                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>

                            <div class="col-md-6">
                                <input type="file" id="avatar"
                                    class="form-control @error('avatar') is-invalid @enderror" name="avatar"
                                    accept="image/png, image/jpeg" value="{{ old('avatar') }}" autocomplete="avatar"
                                    autofocus onclick="changeImage();" value="">

                                @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Fin ajout de l'avatar -->

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{Auth::user()->name}}" required autocomplete="name" autofocus>

                                @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname"
                                class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text"
                                    class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                    value="{{Auth::user()->firstname}}" autocomplete="firstname" autofocus>

                                @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Adresse e-mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{Auth::user()->email}}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Enregister les modifications") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Suppression définitive de votre compte</div>
                <div class="card-body">
                    <form action="{{ route('account.destroy', $user->id) }}" method="DELETE">
                        @csrf
                        <!-- method('DELETE') -->
                        <div class="border-bottom mb-2 pb-2">

                            <p>Après avoir validé la suppression de votre compte, vous n'aurez plus accès à celui-ci,
                                ainsi qu'à vos tweets, followers, etc... <span>Vous serez alors rediriger sur notre page
                                    d'accueil !</span></p>
                            <button type="submit" class="btn btn-outline-danger p-2 btn-lg btn-block" onclick="if(confirm('Voulez-vous vraiment supprimer votre compte ?')){
                                            return true;}else{ return false;}">Supprimer mon
                                compte</button>

                        </div>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<style>
    #avatar {
        border: none;
    }

</style>
