## IX. Création d'un post/commentaire

### A. Création de la Migration/Table "Post"

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

### B. Création du controller

-   Tout d'abord, nous créons notre controller avec les références qui vont bien

```
php artisan make:controller PostController -r
```

<p>
    On demande à LARAVEL de créer un controlleur pour gérer les données de la vue, le "-r" permet de créer ce fichier avec les ressources précharger (function index(), voir(), créer(), modifier(), supprimer() etc...)
</p>

-   Aperçu du controller précédemment crée :

<details>
<summary>Contenu PostController</summary>

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

```

</details>

### C. Création du Model

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

### D. Gestion Vue/Controller/Route/

<p>
    Nous venons de crée notre migration, notre controller et notre model, désormais nous avons besoins de la vue, des routes associés, ainsi que les données gérer dans le controller précédemment crée.
</p>

Pour crée notre page (vue) qui accueillera nos posts, plusieurs solutions existent :

1. Crée la page nous même dans le dossiers "views" et appelé le à votre guise.
2. Utiliser la vue de page d'accueil existante ici : **_"home.blade.php."_**

Dans cet exemple, nous utiliserons la méthode 2, utilisation de la vue existante en la modifiant pour nos besoins.

-   Récapitulatif

1. Vue = **"home.blade.php"** qui reccueillera les données saisies par l'utlisateur
2. Controller = **"PostController"** qui contrôlera les données reccueillit et renverra la réponse
3. Route = **"web.php"** qui comportera les routes qui sont la liaison entre la vue et le controller

Dans ce projet, nous procéderons par étapes :

-   Gestion de la vue du fil d'actualité accueillant nos futurs posts
-   Création d'un post par l'utlisateur
-   Suppression d'un post crée par l'utlisateur

#### Étape 1 - &#128065; - Visibilité de la page

Fichier : "home.blade.php"

-   Il correspondait au visuel suivant :
    ![Base-logged_in.png](Base-logged_in.png)

1.  Modification de la vue

Nous allons modifier ce visuel pour que nous puissions poster des commentaires, les voir et les supprimer.

<details>
<summary>Code de la page</summary>

```php
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
                                    href="{{ route('profil', $post->user->pseudo) }}">
                                    <img class="m-auto rounded img-thumbnail" src="{{$post->user->getAvatar()}}"
                                        width="100%" height="100%">
                                </a>
                                <!--
                                        Avant en dure : src="./img/tweet1.png"
                                        Après en BDD : src = ./img/$post->user->avatar
                                    -->
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('profil', $post->user->pseudo) }}" class="mr-auto"
                                    style="text-decoration: none; color: inherit;">
                                    <div class="d-flex">
                                        <H5 class="font-weight-bold pr-2">{{$post->user->name}}</H5>
                                        <p>{{$post->user->pseudo}}</p>
                                    </div>
                                </a>
                                <form action="{{route('destroy.post', $post->id)}}" method="DELETE" id="myform">
                                    @if ($post->user->name === Auth::user()->name)
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

```

</details>

#### Étape 1 - &#128065; - Controller gérant la vue de la page

-   Création de la fonction index :

```php
 public function index(Post $post)
    {
        //Post de tout le monde
        //$posts = $post->orderBy('id', 'DESC')->where('user_id', Auth::user()->id)->paginate(4);

        //Post de la personne connecté
        $posts = $post
        ->orWhere('user_id', Auth::user()->id)
        ->with('user')
        ->orderBy('id', 'DESC')
        ->paginate(4);


        //Retourne la view des posts
        return view('home', ['posts' => $posts ]);
    }
```

#### Étape 1 - &#128065; - Route faisant la liaison entre la vue et le controller de la page

-   Ajouter la ligne suivante pour que la liaison entre votre vue et votre controller se fassent

```php
//Route::get('/home', 'HomeController@index')->name('home');
//Route de vision de la page de fil d'actualité
Route::get('/home', 'PostController@index')->name('home');
```

-   N'oublier pas de commenter la ligne qui correspondait à la liaison entre le controller (HomeController) et la vue (home.blade.php) de base de LARAVEL c'est-à-dire :

```php
// Ce symbole permet de commenter le code "//"
Route::get('/home', 'HomeController@index')->name('home');
```

Car nous avons modifié la vue pour qu'elle coresponde à nos attentes et pour cela, nous lui avons crée un nouveau controller qui nous est propre appelé "PostController".

### Routes

-   Ajouter les lignes suivantes pour que la liaison entre votre vue et votre controller se fassent

```php
//Route de la méthode post un commentaire (création)
Route::post('/home', 'PostController@create')->middleware('auth')->name('create.post');
//Route de la méthode delete un post (suppression)
Route::get('/home/{id}', 'PostController@destroy')->middleware('auth')->name('destroy.post');
```
