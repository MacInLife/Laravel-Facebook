@extends('layouts.app')
@section('title')
Laravel Facebook - Home
@endsection
@section('content')
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
                    <p><img src="/img/logo_fil-actu.png" alt="" width="20"> Fil d'actualité</p>
                </div>
                <div class="mx-2" style="width:55%;">
                    <div class="card">
                        <div class="card-header">Créer une publication</div>
                        <div class="card-body p-0">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="form-group m-2 ">
                                <form method="post" action="{{route('create.post')}}">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <div class="d-flex">
                                        <a href="{{ route('profil', Auth::user()->id) }}"
                                            class="text-decoration-none text-dark m-auto">
                                            <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                                    src="{{Auth::user()->avatar}}" alt="" width="40"></div>
                                        </a>
                                        <textarea name="text"
                                            class="form-control @error('text') is-invalid @enderror mb-2 border-0"
                                            placeholder="Que voulez-vous dire, {{Auth::user()->firstname}} ?" id="text"
                                            rows="1">{{ old('text') }}</textarea>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="m-2">
                                        <hr>
                                    </div>
                                    <button href="#" class="btn btn-primary btn-sm btn-block" role="button"
                                        aria-pressed="true" type="submit">Publier</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Fil d'actualité -->
                    @if(!$posts)
                    <div class="card my-2">
                        <div class="card-header">Fil d'actualité</div>
                        <div class="card-body">Aucune publication</div>
                    </div>
                    @else
                    @foreach ($posts as $post)
                    @csrf
                    <div class="card my-2">
                        <div class="card-header d-flex my-auto p-2">
                            <a href="{{ route('profil', $post->user->id) }}" class="text-decoration-none text-dark">
                                <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                        src="{{$post->user->getAvatar()}}" alt="" width="40"></div>
                            </a>
                            <div class="mr-auto">
                                <a href="{{ route('profil', $post->user->id) }}" class="text-decoration-none text-dark">
                                    <p class="my-auto">{{$post->user->firstname}} {{$post->user->name}}</p>
                                </a>
                                <p class="text-muted mr-2 my-auto text-secondary font-italic">
                                    {{$post->created_at->locale('fr_FR')->diffForHumans()}}</p>
                            </div>
                            <form action="{{route('destroy.post', $post->id)}}" method="DELETE" id="myform" class="p-2">
                                @if ($post->user->id === Auth::user()->id)
                                <button type="submit" class="btn btn-outline-danger p-2" onclick="if(confirm('Voulez-vous vraiment supprimer ce post ?')){
                                                return true;}else{ return false;}">Supprimer</button>
                                @endif
                            </form>
                        </div>
                        <div class="card-body outer p-2">
                            <p class="m-0 text-info">
                                {{$post->text }}
                            </p>

                        </div>

                    </div>
                    @endforeach
                    @endif
                    {{$posts->links()}}
                </div>

                <!-- Suggestions d'amis -->
                <div class="card border-0 bg-light" style="width:35%;">
                    <div class="navbar px-0 bg-light" style="
    border-bottom: 1px solid lightgrey;">
                        <h6 class=" mt-2 pl-4">Suggestions d'amis ({{$users->count()}})
                        </h6>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <svg width="20" height="20" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="angle-down" class="svg-inline--fa fa-angle-down fa-w-10" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path fill="currentColor"
                                    d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z">
                                </path>
                            </svg>
                        </button>
                        <div class="collapse navbar-collapse bg-white p-2" id="navbarSupportedContent">
                            <div class="content">
                                @foreach ($users as $user)
                                <div class="card-body d-flex p-0 pb-2">
                                    <a href="{{ route('profil', $user->id) }}" class="my-auto mr-auto"
                                        style="text-decoration: none; color: inherit;">
                                        <div class="d-flex">
                                            <img style="border-radius:50%; border:1px solid #DADDE1;"
                                                src="{{$user->avatar}}" alt="" width="40">
                                            <p class="p-2 my-auto">{{$user->firstname}}</p>
                                            <p class="my-auto">{{$user->name}}</p>
                                        </div>
                                    </a>
                                    <div class="ml-2 my-auto">
                                        @if($user == true)
                                        @foreach ($user->amisNotActive as $amis)
                                        @if($user->amisNotActive)
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
                                        @endif
                                        @endforeach
                                        @foreach ($user->amisWait as $amis)
                                        @if($user->amisWait)
                                        <div class="border border-dark m-0">
                                            <div class="bg-light d-flex m-auto">
                                                <div class="ml-2">
                                                    <img src="/img/user-invit.png" alt="" width="12" height="12">
                                                </div>
                                                <p class="ml-2 mr-2 my-auto">Invitation envoyée</p>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
</div>
@endsection
