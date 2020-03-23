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
                    <p class="">

                        <img style="border-radius:50%; border:1px solid #DADDE1;" src="{{Auth::user()->avatar}}" alt=""
                            width="20"> {{Auth::user()->firstname}} {{Auth::user()->name}}
                    </p>
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
                                        <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                                src="{{Auth::user()->avatar}}" alt="" width="40"></div>
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
                    <div class="card mt-2">
                        <div class="card-header">Fil d'actualité</div>
                        <div class="card-body outer">
                            @if($posts)
                            @foreach ($posts as $post)
                            @csrf
                            <div class="child border-bottom mb-2 pb-2">
                                <div class="mb-2 mr-2 float-left" style="width:80px;"><a
                                        href="{{ route('profil', $post->user->id) }}">
                                        <img class="m-auto rounded img-thumbnail" src="{{$post->user->getAvatar()}}"
                                            width="100%" height="100%">
                                    </a>
                                </div>
                                <div class="d-flex">
                                    <a href="{{ route('profil', $post->user->id) }}" class="mr-auto"
                                        style="text-decoration: none; color: inherit;">
                                        <div class="d-flex">
                                            <H5 class="font-weight-bold pr-2">{{$post->user->name}}</H5>
                                            <p>{{$post->user->pseudo}}</p>
                                        </div>
                                    </a>
                                    <form action="{{route('destroy.post', $post->id)}}" method="DELETE" id="myform">
                                        @if ($post->user->id === Auth::user()->id)
                                        <button type="submit" class="btn btn-outline-danger p-2" onclick="if(confirm('Voulez-vous vraiment supprimer ce post ?')){
                                                return true;}else{ return false;}">Supprimer</button>
                                        @endif
                                    </form>
                                </div>
                                <div class="d-flex">
                                    <p class="mr-auto w-70 text-info">
                                        {{$post->text }}
                                    </p>
                                    <p class="p-2 text-secondary font-italic">
                                        {{$post->created_at->locale('fr_FR')->diffForHumans()}}</p>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            {{$posts->links()}}
                        </div>
                    </div>
                </div>
                <div class="card border-0 bg-light" style="width:25%;">
                    <div class="navbar px-0 bg-light" style="
    border-bottom: 1px solid lightgrey;">
                        <h6 class=" mt-2 pl-4">Suggestions d'amis ({{$users->count()-1}})
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
                                @if ($user != Auth::user())
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
                                    <div class=" my-auto">
                                        @if($users == true)
                                        <a href="" class="btn btn-primary btn-sm" role="button"
                                            aria-pressed="true">Ajouter</a>
                                        @endif
                                    </div>
                                </div>
                                @endif
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
