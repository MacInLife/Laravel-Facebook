[Logo Laravel Facebook](docs/logo-laravel-facebook.png)

# Facebook Laravel

Créer un réseau social clone de Facebook en utilisant le framework PHP Laravel.

## Tutorial Étapes

-   **I. [Création du projet](docs/creation-projet.md)** > _Projet initial vide_

-   **II. [Création d'un repo git](docs/creation-repo-git.md)** > _Gestion du versionning de fichier_

-   **III. [Page de connexion](docs/page-connexion.md)** > _Modification de page d'accueil LARAVEL en page de connexion pour Facebook_

-   **IV. [Champs "prénom" et "avatar"](docs/firstname-and-avatar.md)** > _Ajout du champ prénom à notre formulaire d'inscription, et ajout de l'avatar pour l'intégration futur de celui-ci._

-   **V. [Intégration de la Gestion des erreurs en français](docs/gestion-erreur-fr.md)** > _Tester vos formulaires en faisant des erreurs pour vérifier la bonne application._

-   **VI. [Barre de navigation](docs/barre-navigation.md)** > _Modification de l'apparence de la barre de navigation de LARAVEL après connexion, par une barre de navigation ressemblante à celle de Facebook, ainsi qu'un sous-menu correspondant._

-   **VII. [Page Compte](docs/page-compte.md)** > _Création de la page de gestion du compte avec le controller et les routes associés "AccountController" (modification données du compte, ajout d'un nom d'utilisateur \[migration], suppression avatar/compte)._

-   **VIII. [Page Profil](docs/page-profil.md)** > _Création de la page profil avec le controller et les routes associés "ProfilController" (Ajout/Vision/Suppression de ses propres posts sur son journal et de ses ami(e)s)._

## VIII - Création de la page "Profil"

### A. Création de la vue

Cette page permettra à l'utilisateur de voir son profil, c'est-à-dire de pouvoir poster un commentaire, voir ses demandes d'amis et ses amis.

-   Crée le fichier **"profil.blade.php"** dans /ressources/views

```php
@extends('layouts.app')
@section('content')
<h1>Page Compte</h1>
@endsection
```

-   Ajout du lien dans la barre de navigation du fichier **"app.blade.php"**

```php
  <a class="dropdown-item" href="{{ route('profil', Auth::user()->id ) }}">Profil</a>
```

### B. Création du controleur

1. Controlleur "ProfilController"

    `php artisan make:controller ProfilController`

-   Contenu du controlleur :

```php
  public function index($slug, User $user)
    {
        $u = $user->wherePseudo($slug)->first();

        if (!$u) {
            $u = $user->whereId($slug)->first();
            if (!$u) {
                return redirect('/', 302);
            }
        }

        //Retourne la view des posts
        return view('/auth/profil', [ 'user' => $u ]);
    }
```

### C. Création de la route

-   Gestion par le pseudo ou par l'identifiant

    `Route::get('/profil/{slug}', 'ProfilController@index')->name('profil');`

### D. Optimisation de la vue

1. Vue du profil sans les données du fil d'actualité et du post d'une commentaire

<details>
<summary>Code vue "profil.blade.php"</summary>

```php
@extends('layouts.app')
@section('title')
Laravel Facebook - Profil
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
                    style="width:168px; height:168px; position: absolute;   top: 82%;   left: 11%;  transform: translate(-50%,-50%)">
                    <img id="user-avatar" class="m-auto"
                        style="width:168px; border-radius:50%; border:1px solid #DADDE1;" src="{{$user->getAvatar()}}"
                        width="100%" height="100%">
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
                                    <img src="{{$user->avatar}}" alt="">
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

@endsection

```

</details>

### E. Création d'un post/commentaire

#### 1. Création de la Migration/Table "Post"

-   Crée une migration pour effectuer des posts/commentaire

```
php artisan make:migration create_posts_table
```

Son contenu initial est le suivant :

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

```

-   Modification du contenu pour faire correspondre nos posts à nos utilisateurs
    -   Ajout d'un champ "text
    -   Ajout d'un champ faisant la liaison avec l'id de l'utilisateurs de la table "users.

```php
  $table->string('text');
  $table->integer('user_id')->unsigned();
```

-   Lancement de la migration

```
php artisan migrate
```

#### 2. Création du controller

-   Tout d'abord, nous créons notre controller avec les références qui vont bien

```
php artisan make:controller PostController -r
```

On demande à LARAVEL de créer un controlleur pour gérer les données de la vue, le "-r" permet de créer ce fichier avec les ressources précharger (function index(), voir(), créer(), modifier(), supprimer() etc...)

#### 3. Création du Model

PS : Nous aurions pu crée les 3 fichier directement (Migration, Ressources, Controller) grâce à la commande suivante :

```
php artisan make:model Post -mrc
```

Vu que nous avons fait par étapes continuons, création du model :

```
php artisan make:model Post
```

Le model permet la liaison entre les différentes tables mais aussi de vérifier que la valeur correspond bien à ce que le champs demandent.

Nous avons donc besoin ici de rajouter la liaison entre nos posts et notre utilisateurs, pour cela écrire la fonction suivante dans notre model :

```php
    //Gestion de la liaison Many to Many
   public function user(){
        return $this->belongsTo(\App\User::class);
    }
```

Notre modèle est désormais prêt !

Revenons a notre controller...

#### 4. Gestion du controller
