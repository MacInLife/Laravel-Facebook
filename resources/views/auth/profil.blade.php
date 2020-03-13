@extends('layouts.app')
@section('title')
Laravel Facebook - Profil
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            <div class="position-relative">
                <img src="/img/banner.jpeg" alt="" width="100%" height="315">
                <div class="mx-auto mb-2"
                    style="width:168px; height:168px; position: absolute;   top: 82%;   left: 13%;  transform: translate(-50%,-50%)">
                    <img id="user-avatar" class="m-auto"
                        style="width:168px; border-radius:50%; border:1px solid #DADDE1;"
                        src="{{Auth::user()->getAvatar()}}" width="100%" height="100%">
                </div>
            </div>
            <nav class="nav-pills nav-justified">
                <div class="nav nav-tabs bg-light card-header p-0" id="nav-tab" role="tablist"
                    style="justify-content: space-between;">
                    <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                        aria-controls="nav-home" aria-selected="true">
                    </a>
                    <a class="nav-item nav-link dropdown-toggle active" id="nav-home-tab" data-toggle="tab"
                        href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Journal
                        <span class="caret"></span>
                    </a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                        aria-controls="nav-profile" aria-selected="false">Amis ()</a>
                </div>
            </nav>

            <div class="tab-content card-body bg-white" id="nav-tabContent">

                <!-- Partie Tweets = Tweets du profil de la personne -->
                coucou
            </div>

        </div>
    </div>
</div>
</div>

@endsection
