@extends('layouts.app')
@section('title')
Laravel Facebook - Profil
@endsection

@section('style')
<style>
    .img-avatar>div {
        opacity: 0;
        transition: all 0.5s ease;
    }

    .img-avatar>div:hover {
        opacity: 1;
    }

    .bg-black {
        background: #00000099;
        top: 50%;
        position: absolute;
        width: 100%;
        height: 50%;
    }

    #dialogEditAvatar[open] {
        display: block;
        background: aliceblue;
        border-radius: 20px;
        border: 1px solid darkblue;
        top: 50%;
        left: 35%;
        transform: translate(-50%, -50%);
        position: absolute;
    }

</style>
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            <div class="position-relative">
                <img src="/img/banner.jpeg" alt="" width="100%" height="315">
                <div class="mx-auto mb-2"
                    style="width:168px; height:168px; position: absolute;   top: 82%;   left: 11%;  transform: translate(-50%,-50%); border-radius:50%; overflow:hidden;">
                    <a class="img-avatar" onclick="showDialogEditAvatar()">
                        <img id=" user-avatar" class="m-auto"
                            style="width:168px; border-radius:50%; border:1px solid #DADDE1;"
                            src="{{$user->getAvatar()}}" width="100%" height="100%">
                        <div class="bg-black">
                            <div class="text-center mt-2">
                                <img src="/img/apphoto.png" alt="" width="26" height="21">
                            </div>
                            <p class="text-white text-center">Mettre à jour</p>
                        </div>
                    </a>
                </div>
                <div style="position: absolute;   top: 84%;   left: 30%;  transform: translate(-50%,-50%)">
                    <H3 class="text-white">{{$user->firstname}} {{$user->name}}</H3>
                    @if($user->pseudo)
                    <p class="text-white">({{$user->pseudo}})</p>
                    @endif
                </div>
            </div>
            <nav class="nav-pills nav-justified">
                <div class="nav nav-tabs bg-light card-header p-0" id="nav-tab" role="tablist"
                    style="justify-content: space-between;">
                    <a class="nav-item nav-link bg-white" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                        role="tab" aria-controls="nav-home" aria-selected="true">
                    </a>
                    <a class="nav-item nav-link dropdown-toggle active" id="nav-home-tab" data-toggle="tab"
                        href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Journal
                        <span class="caret"></span>
                    </a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                        aria-controls="nav-profile" aria-selected="false">

                        Amis ()
                    </a>
                </div>
            </nav>

            <div class="tab-content card-body" id="nav-tabContent">

                <!-- Partie Journal -->
                <div class="tab-pane fade show active d-flex" id="nav-home" role="tabpanel"
                    aria-labelledby="nav-home-tab">

                    <!-- Contenu gauche Amis -->
                    <div class="card w-50 m-1 h-50">
                        <div class="d-flex card-header bg-white my-auto">
                            <div><img src="/img/logo-amis.png" alt="" width="40"></div>
                            <H4 class="my-auto ml-2">Amis ()</H4>
                        </div>

                        <div class="d-flex flex-wrap">
                            <div class="m-2">
                                <div class="">
                                    <img src="{{$user->avatar}}" alt="" width="100">
                                </div>
                                <p>{{$user->firstname}} {{$user->name}}</p>
                            </div>


                        </div>
                    </div>

                    <!-- Contenu journal -->
                    <div class="w-75 m-1">
                        <!-- Créer une Publication -->
                        <div class="card mb-1">
                            <div class="card-header">Créer une publication</div>
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
                                    <form method="post" action="">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <textarea name="text"
                                            class="form-control @error('text') is-invalid @enderror mb-2" id="text"
                                            rows="3">{{ old('text') }}</textarea>
                                        {{csrf_field()}}
                                        <button href="#" class="btn btn-primary btn-lg btn-block" role="button"
                                            aria-pressed="true" type="submit">Publier</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Publication -->
                        <div class="card mb-1">
                            <div class="card-header d-flex my-auto p-2">

                                <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                        src="{{Auth::user()->avatar}}" alt="" width="40"></div>
                                <div>
                                    <p class="my-auto">{{Auth::user()->firstname}} {{Auth::user()->name}}</p>
                                    <p class="text-muted mr-2 my-auto">Date</p>
                                </div>
                            </div>
                            <div class="card-body">


                            </div>
                        </div>

                    </div>





                </div>

                <!-- Partie Amis -->
                <div class="tab-pane fade bg-white" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    coucou amis
                </div>

            </div>

        </div>
    </div>
</div>
</div>
<!-- Boite de dialogue d'édition de l'avatar -->
<dialog id="dialogEditAvatar">
    <button type="button" class="close" onclick="closeDialogEdit()" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <H3 class="text-center bg-light">Modifier la miniature</H3>
    <div class="m-2">
        <hr>
    </div>
    <div class="mx-auto mb-2" style="width:80px; height:80px;"><img id="user-avatar" class="m-auto"
            style="width:80px; border-radius:50%; border:1px solid #DADDE1;" src="{{Auth::user()->getAvatar()}}"
            width="100%" height="100%">
    </div>
    <form action="{{ route('profil.updateAvatar', $user->id) }}" method="POST" class="text-center"
        enctype="multipart/form-data">
        @csrf
        <input type="file" id="avatar" class="form-control @error('avatar') is-invalid @enderror" name="avatar"
            accept="image/png, image/jpeg" value="{{ old('avatar') }}" autocomplete="avatar" autofocus
            onclick="changeImage();" value="">
        <button type="submit" class="btn btn-primary mt-2 text-center" style="background-color:#385898;">
            {{ __("Enregister") }}
        </button>
        </div>

    </form>
</dialog>
<script>
    var e = document.getElementById("dialogEditAvatar");

    function showDialogEditAvatar() {
        e.show();
        console.log(event.type, e, StyleSheet, x.userID);
    }

    function closeDialogEdit() {
        e.close();
        console.log(event.type, e, StyleSheet);
    }

</script>
@endsection
