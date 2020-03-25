@extends('layouts.app')
@section('title')
Laravel Facebook - Profil
@endsection

@section('style')
<style>
    .img-avatar>.bg-black {
        opacity: 0;
        transition: all 0.5s ease;
    }

    .img-avatar>.bg-black:hover {
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

    .photo-cover {
        left: 5%;
        display: flex;
        position: absolute;
        top: 10%;
        border-radius: 3px;
        padding: 2px;
    }

    .img-cover>.bg-cover {
        opacity: 0;
        transition: all 0.5s ease;
    }

    .img-cover>.bg-cover:hover {
        opacity: 1;
    }

    .bg-cover {
        left: 5%;
        display: flex;
        position: absolute;
        top: 10%;
        background: #00000099;
        border: 1px solid white;
        border-radius: 3px;
        padding: 2px;
        height: 28px;
    }

    #dialogEditCover[open] {
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
                @if($user->name === Auth::user()->name)
                <a class="img-cover" onclick="showDialogEditCover()">
                    <img src="{{$user->getCover()}}" alt="" width="100%" height="315">
                    <div class="photo-cover">
                        <img src="/img/apphoto.png" alt="" width="26" height="21">
                    </div>
                    <div class="bg-cover">
                        <div class="text-center">
                            <img src="/img/apphoto.png" alt="" width="26" height="21">
                        </div>
                        <p class="text-white mx-2">Modifier la photo de courverture</p>
                    </div>
                </a>
                @else
                <img src="{{$user->getCover()}}" alt="" width="100%" height="315">
                @endif
                <div class="mx-auto mb-2"
                    style="width:168px; height:168px; position: absolute;   top: 82%;   left: 11%;  transform: translate(-50%,-50%); border-radius:50%; overflow:hidden;">
                    @if($user->name === Auth::user()->name)
                    <a class="img-avatar" onclick="showDialogEditAvatar()">
                        <img id="user-avatar" class="m-auto"
                            style="width:168px; border-radius:50%; border:1px solid #DADDE1;"
                            src="{{$user->getAvatar()}}" width="100%" height="100%">
                        <div class="bg-black">
                            <div class="text-center mt-2">
                                <img src="/img/apphoto.png" alt="" width="26" height="21">
                            </div>
                            <p class="text-white text-center">Mettre à jour</p>
                        </div>
                    </a>
                    @else
                    <img id="user-avatar" class="m-auto"
                        style="width:168px; border-radius:50%; border:1px solid #DADDE1;" src="{{$user->getAvatar()}}"
                        width="100%" height="100%">
                    @endif

                </div>
                <div style="position: absolute;   top: 84%;   left: 30%;  transform: translate(-50%,-50%)">
                    <H3 class="text-white">{{$user->firstname}} {{$user->name}}</H3>
                    @if($user->pseudo)
                    <p class="text-white">({{$user->pseudo}})</p>
                    @endif
                </div>
                <!-- Bouton de demande d'amis "Ajouter"-->
                @if($user->name != Auth::user()->name)
                @if($amis == false)
                <a class="text-decoration-none text-dark" href="{{ route('profil.amisAdd', $user->id)}}" role="button"
                    aria-pressed="true">
                    <div class="border border-dark"
                        style="position: absolute;   top: 84%;   left: 90%;  transform: translate(-50%,-50%)">
                        <div class="bg-light d-flex m-auto">
                            <div class="ml-2">
                                <img src="/img/user-add.png" alt="" width="12" height="12">
                            </div>
                            <p class="my-auto mx-2">Ajouter</p>
                        </div>
                    </div>
                </a>
                @elseif($amis->amisDemande == false && $amis->amisActive == false)
                <a class="text-decoration-none text-dark" href="{{ route('profil.amisInvit', $user->id)}}" role="button"
                    aria-pressed="true">
                    <div class="border border-dark"
                        style="position: absolute;   top: 84%;   left: 90%;  transform: translate(-50%,-50%)">
                        <div class="bg-light d-flex m-auto">
                            <div class="ml-2">
                                <img src="/img/user-invit.png" alt="" width="12" height="12">
                            </div>
                            <p class="my-auto mx-2">Invitation envoyée</p>
                        </div>
                    </div>
                </a>
                @else
                <a class="text-decoration-none text-dark" href="{{ route('profil.amisDelete', $user->id)}}"
                    role="button" aria-pressed="true">
                    <div class="border border-dark"
                        style="position: absolute;   top: 84%;   left: 90%;  transform: translate(-50%,-50%)">
                        <div class="bg-light d-flex m-auto">
                            <div class="ml-2">
                                <img src="/img/" alt="" width="12" height="12">
                            </div>
                            <p class="my-auto mx-2">Retier des amis</p>
                        </div>
                    </div>
                </a>
                @endif
                @endif

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
                        @if($user->name === Auth::user()->name)
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
                                                class="text-decoration-none text-dark">
                                                <div class="mr-2"><img
                                                        style="border-radius:50%; border:1px solid #DADDE1;"
                                                        src="{{Auth::user()->avatar}}" alt="" width="40"></div>
                                            </a>
                                            <textarea name="text"
                                                class="form-control @error('text') is-invalid @enderror mb-2 border-0"
                                                placeholder="Que voulez-vous dire, {{Auth::user()->firstname}} ?"
                                                id="text" rows="1">{{ old('text') }}</textarea>
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
                        @endif
                        <!-- Publication -->
                        @if(!$posts)
                        <div class="card my-2">
                            <div class="card-header">Publication du journal</div>
                            <div class="card-body">Aucune publication</div>
                        </div>
                        @else
                        @foreach ($posts as $post)
                        @if($post->user->name === $user->name)
                        @csrf
                        <div class="card my-2">
                            <div class="card-header d-flex my-auto p-2">
                                <a href="{{ route('profil', $post->user->id) }}" class="text-decoration-none text-dark">
                                    <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                            src="{{$post->user->getAvatar()}}" alt="" width="40"></div>
                                    <div class="mr-auto">
                                </a>
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
                    @endif
                    @endforeach
                    @endif

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
<!-- Boite de dialogue d'édition de la photo de couverture -->
<dialog id="dialogEditCover">
    <button type="button" class="close" onclick="closeDialogEditCover()" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <H3 class="text-center bg-light">Modifier la photo de couverture</H3>
    <div class="m-2">
        <hr>
    </div>
    <div class="mx-auto mb-2"><img id="user-cover" class="m-auto" style="width:350px;border:1px solid #DADDE1;"
            src="{{Auth::user()->getCover()}}" width="100%" height="100%">
    </div>
    <form action="{{ route('profil.updateCover', $user->id) }}" method="POST" class="text-center"
        enctype="multipart/form-data">
        @csrf
        <input type="file" id="cover" class="form-control @error('cover') is-invalid @enderror" name="cover"
            accept="image/png, image/jpeg" value="{{ old('cover') }}" autocomplete="cover" autofocus
            onclick="changeImage();" value="">
        <button type="submit" class="btn btn-primary mt-2 text-center" style="background-color:#385898;">
            {{ __("Enregister") }}
        </button>
        </div>

    </form>
</dialog>
<script>
    var c = document.getElementById("dialogEditCover");

    function showDialogEditCover() {
        c.show();
        console.log(event.type, e, StyleSheet, x.userID);
    }

    function closeDialogEditCover() {
        c.close();
        console.log(event.type, e, StyleSheet);
    }

</script>
@endsection
