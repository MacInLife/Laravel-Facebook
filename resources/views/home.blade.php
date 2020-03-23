@extends('layouts.app')
@section('title')
Laravel Facebook - Home
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif


            <div class="d-flex">

                <div class="card mr-2 w-75">
                    <div class="card-header">Tweets</div>
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
                                <!-- 
                                        Avant en dure : src="./img/tweet1.png"
                                        Après en BDD : src = ./img/$post->user->avatar 
                                    -->
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
                    <!--<a href="#" id="showMore">Show More</a>-->
                </div>

                <div class="card w-50 h-50">
                    <div class="card-header">Ecrire un tweet</div>
                    <div class="card-body">
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
                                <textarea name="text" class="form-control @error('text') is-invalid @enderror mb-2"
                                    id="text" rows="3">{{ old('text') }}</textarea>
                                {{csrf_field()}}
                                <button href="#" class="btn btn-primary btn-lg btn-block" role="button"
                                    aria-pressed="true" type="submit">Tweet</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
</div>
@endsection
