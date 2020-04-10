@extends('layouts.app')
@section('title')
Laravel Facebook - Recherche
@endsection

@section('style')
<!--Ici insérer votre style CSS propre à la page -->
@endsection
@section('content')
<!--Ici insérer votre contenu de recherche -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif

            <div class="d-flex">
                <div class="" style="width:20%;">
                    <a href="{{ route('profil', Auth::user()->id) }}" class="text-decoration-none text-dark m-auto">
                        <p class="">
                            <img style="border-radius:50%; border:1px solid #DADDE1;" src="{{Auth::user()->avatar}}"
                                alt="" width="20"> {{Auth::user()->firstname}} {{Auth::user()->name}}
                        </p>
                    </a>
                    <div class="m-2">
                        <hr style="opacity:0;">
                    </div>
                    <p><img src="/img/result.png" alt="" width="20"> Résultat</p>
                </div>
                <div class="mx-2" style="width:60%;">
                    <div class="card">
                        <div class="card-header">Personnes</div>
                        <div class="card-body p-2 my-2">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(!$users->isEmpty())
                            @foreach($users as $user)

                            <div class="d-flex my-2">
                                <a href="{{ route('profil', $user->id) }}" class="text-decoration-none text-dark">
                                    <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                            src="{{$user->getAvatar()}}" alt="" width="40">
                                    </div>
                                </a>
                                <a href="{{ route('profil', $user->id) }}" class="text-decoration-none text-dark">
                                    <p class="my-auto">{{$user->firstname}} {{$user->name}}</p>
                                    <p class="my-auto">{{$user->pseudo}}</p>
                                </a>
                                <div class="p-2 ml-auto">
                                    @switch(Auth::user())
                                    @case ($user->isFriend(Auth::user()) == 0 &&
                                    Auth::user()->demandeAmis($user) == 1 &&
                                    Auth::user()->demandeRecu($user) == 1)
                                    <a class="text-decoration-none text-dark"
                                        href="{{ route('profil.amisAdd', $user->id)}}" role="button"
                                        aria-pressed="true">
                                        <div class="border border-dark">
                                            <div class="bg-light d-flex m-auto">
                                                <div class="ml-2">
                                                    <img src="/img/user-add.png" alt="" width="12" height="12">
                                                </div>
                                                <p class="my-auto mx-2">Ajouter</p>
                                            </div>
                                        </div>
                                    </a>
                                    @break
                                    @case (Auth::user()->demandeAmis($user) == 1)
                                    <div class="border border-dark" style="width:160px;">
                                        <div class="bg-light d-flex m-auto">
                                            <div class="ml-2">
                                                <img src="/img/user-invit.png" alt="" width="12" height="12">
                                            </div>
                                            <p class="my-auto mx-2 text-secondary">Invitation envoyée
                                            </p>
                                        </div>
                                    </div>
                                    @break
                                    @case (Auth::user()->demandeRecu($user) == 1)
                                    <div class="border border-dark">
                                        <div class="bg-light d-flex m-auto">
                                            <div class="ml-2">
                                                <img src="/img/user-recu.png" alt="" width="12" height="12">
                                            </div>
                                            <p class="my-auto mx-2 text-secondary">Invitation reçue</p>
                                        </div>
                                    </div>
                                    @break
                                    @case (Auth::user()->isFriend($user) == 1)
                                    <a class="text-decoration-none text-dark"
                                        href="{{ route('profil.amisDelete', $user->id)}}" role="button"
                                        aria-pressed="true">
                                        <div class="border border-dark">
                                            <div class="bg-light d-flex m-auto">
                                                <div class="ml-2">
                                                    <img src="/img/user-supp.png" alt="" width="12" height="12">
                                                </div>
                                                <p class="my-auto mx-2">Retirer des amis</p>
                                            </div>
                                        </div>
                                    </a>
                                    @break
                                    @default
                                    <a class="text-decoration-none text-dark"
                                        href="{{ route('profil.amisAdd', $user->id)}}" role="button"
                                        aria-pressed="true">
                                        <div class="border border-dark">
                                            <div class="bg-light d-flex m-auto">
                                                <div class="ml-2">
                                                    <img src="/img/user-add.png" alt="" width="12" height="12">
                                                </div>
                                                <p class="my-auto mx-2">Ajouter</p>
                                            </div>
                                        </div>
                                    </a>
                                    @break
                                    @endswitch
                                </div>
                            </div>
                            <div class="mx-2">
                                <hr class="m-1 p-0">
                            </div>

                            @endforeach
                            @else
                            <div class="d-flex my-2">
                                Aucun résultat corespondant
                            </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @endsection
