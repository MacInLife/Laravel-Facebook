@extends('layouts.app')
@section('title')
Laravel Facebook - Home
@endsection
@section('style')
<style>
    .btn-coms {
        position: absolute;
        right: 20px;
        background: none;
        transition: all 0.5s ease;
        border: none;
        padding: 0.45rem 0.75rem;
    }

    .btn-coms:hover {
        position: absolute;
        right: 20px;
        background: none;
        transition: all 0.5s ease;
        border: none;
        padding: 0.45rem 0.75rem;
    }

    .btn-coms>.svgIcon>path {
        transition: all 0.5s ease;
    }

    .btn-coms:hover>.svgIcon>path {
        fill: #3490dc;
        transition: all 0.5s ease;
    }

    .active-comment.active>div>p {
        color: #3490dc;
        transition: all 0.5s ease;
    }

    .active-comment.active>div>img {
        content: url('/img/coms0.png');
        transition: all 0.5s ease;
    }

    .comment {
        display: none;
        transition: all 1s ease-in-out;
    }

    .comment.active {
        display: block;
        transition: all 1s ease-in-out;
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
                    @if($posts->isEmpty())
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
                        <div class="card-body px-2 py-1">
                            <p class="m-0 text-info" style="font-size:16px;">
                                {{$post->text }}
                            </p>
                            <div class="mx-2">
                                <hr class="m-1 p-
                                        0">
                            </div>
                            <div class="d-flex m-0">
                                <img src="/img/likes.png" alt="Icone nombre de j'aime" width="18" height="18"
                                    class="my-auto">
                                <p class="px-1 m-0 my-auto text-muted">{{$post->postLike->count()}}</p>
                            </div>
                            <div class="mx-2">
                                <hr class="m-1 p-
                                        0">
                            </div>
                            <div class="row m-0">
                                @if(!Auth::user()->isLike($post))
                                <a href="{{route('post.like', $post->id)}}"
                                    class="text-decoration-none text-secondary w-50">
                                    <div class="d-flex m-0 justify-content-center">
                                        <img src="/img/unlike_post.png" alt="Aimer un post" width="18" height="18"
                                            class="my-auto">
                                        <p class="px-1 m-0 my-auto">J'aime</p>
                                    </div>
                                </a>
                                @else
                                <a href="{{route('post.unlike', $post->id)}}"
                                    class="text-decoration-none text-secondary w-50">
                                    <div class="d-flex m-0 justify-content-center">
                                        <img src="/img/like_post.png" alt="Aimer un post" width="18" height="18"
                                            class="my-auto">
                                        <p class="px-1 m-0 my-auto text-primary">J'aime</p>
                                    </div>
                                </a>
                                @endif
                                <a href="#commenter" class="text-decoration-none text-secondary w-50 active-comment">
                                    <div class="d-flex m-0 justify-content-center">
                                        <img src="/img/coms.png" alt="Commenter un post" width="18" height="18"
                                            class="my-auto">
                                        <p class="px-1 m-0 my-auto">Commenter</p>
                                    </div>
                                </a>
                            </div>

                            <div class="mx-2">
                                <hr class="m-1 p-0">
                            </div>
                            <!--Partie affichage des commentaires-->
                            @if(!$post->coms->isEmpty())
                            @foreach ($post->coms as $com)
                            @csrf
                            <div class="d-flex m-auto">
                                <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                        src="{{$com->user->getAvatar()}}" alt="" width="32"></div>
                                <p class="m-0 mb-1 px-2 py-1"
                                    style="font-size:13px; border-radius:50px; background:#f2f3f5;">
                                    <a href="{{ route('profil', $com->user->id) }}"
                                        class="text-decoration-none text-blue mr-1">{{$com->user->firstname}}
                                        {{$com->user->name}}</a> {{$com->text }}
                                </p>
                                @if($com->postLike->count() != 0)
                                <div class="d-flex m-0 bg-white border bg-white"
                                    style="border-radius:50px; height:20px; ">
                                    <img src="/img/likes.png" alt="Icone nombre de j'aime" width="16" height="16"
                                        class="my-auto">
                                    <p class="mx-1 m-0 my-auto text-muted" style="font-size:13px;">
                                        {{$com->postLike->count()}}</p>
                                </div>
                                @endif
                                <form action="{{route('destroyCom.com', $com->id)}}" method="DELETE" id="myform"
                                    class="pl-2">
                                    @if ($com->user->id === Auth::user()->id)
                                    <button type="submit" class="btn  p-0 px-1" onclick="if(confirm('Voulez-vous vraiment supprimer ce post ?')){
                                                return true;}else{ return false;}"><img src="./img/delete.png"
                                            alt="Poubelle" width="14"></button>
                                    @endif
                                </form>
                            </div>
                            <div class="d-flex my-auto pb-2">
                                @if(!Auth::user()->isLike($com))
                                <a href="{{route('post.like', $com->id)}}" class="text-decoration-none text-secondary">
                                    <p class="m-0 pl-5" style="font-size:14px;">J'aime</p>
                                </a>
                                @else
                                <a href="{{route('post.unlike', $com->id)}}" class="text-decoration-none text-indigo">
                                    <p class="m-0 pl-5" style="font-size:14px;">J'aime</p>
                                </a>
                                @endif

                                <p class="text-muted mx-2 my-auto text-secondary font-italic" style="font-size:14px;">
                                    - {{$com->created_at->locale('fr_FR')->diffForHumans()}}</p>
                            </div>
                            @endforeach
                            @endif

                            <!--Partie créations des commentaires-->
                            <div class="form-group m-2 comment">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <form method="post" action="{{route('createCom.com')}}">
                                    <input type="hidden" name="parent_id" value="{{ $post->id }}">
                                    <div class="d-flex m-auto">
                                        <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                                src="{{Auth::user()->avatar}}" alt="" width="32"></div>
                                        <input name="text" class="form-control @error('text') is-invalid @enderror mb-2"
                                            id="commenter" type="text" style="border-radius:50px; background:#f2f3f5;"
                                            placeholder="Votre commentaire...">{{ old('text') }}</input>
                                        <button href="#" class="btn btn-primary btn-coms" role="button"
                                            aria-pressed="true" style="height:37px;" type="submit">
                                            <svg class="svgIcon" height="16px" width="16px" version="1.1"
                                                viewBox="0 0 16 16" x="0px" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" y="0px">
                                                <path
                                                    d="M11,8.3L2.6,8.8C2.4,8.8,2.3,8.9,2.3,9l-1.2,4.1c-0.2,0.5,0,1.1,0.4,1.5C1.7,14.9,2,15,2.4,15c0.2,0,0.4,0,0.6-0.1l11.2-5.6 C14.8,9,15.1,8.4,15,7.8c-0.1-0.4-0.4-0.8-0.8-1L3,1.1C2.5,0.9,1.9,1,1.5,1.3C1,1.7,0.9,2.3,1.1,2.9L2.3,7c0,0.1,0.2,0.2,0.3,0.2 L11,7.7c0,0,0.3,0,0.3,0.3S11,8.3,11,8.3z"
                                                    fill="#BEC3C9"></path>
                                            </svg>
                                        </button>
                                        {{csrf_field()}}
                                    </div>

                                </form>
                            </div>
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
                                    <div class="p-2 my-auto">
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
<!-- Toujours mettre cette balise avant ses instructions ou instances -->
<script src="http://code.jquery.com/jquery-3.4.0.min.js"></script> <!-- JQuery est inclus ! -->
<script>
    $(document).ready(function () {
        // $(".active-comment").click(function () {
        //     console.log(event.type);
        // });


        /* Animation des commentaires - Page Home */
        let boutonComment = document.querySelectorAll('.active-comment'),
            inputComment = document.querySelectorAll('.comment'),
            maskInputComment = document.querySelectorAll('.comment');

        boutonComment.forEach(function (el, index) {
            el.addEventListener('click', function (event) {
                console.log(event.currentTarget, index, event.type);
                event.preventDefault();
                maskInput();

                let com = event.currentTarget;
                com.classList.add('active');
                console.log(inputComment[index]);
                inputComment[index].classList.add('active');

            });
        });

        maskInputComment.forEach(function (el, index) {
            el.addEventListener('click', function (event) {
                console.log(event.currentTarget, index);
                event.preventDefault();
                maskInput();

            });
        });

        function maskInput() {

            boutonComment.forEach(function (el, index) {
                el.classList.remove('active');
            });
            inputComment.forEach(function (el, index) {
                el.classList.remove('active');
            });
        }

    });

</script>
