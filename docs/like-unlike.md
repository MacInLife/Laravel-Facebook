## XII. J'aime / J'aime pas

### A. Création de la Migration/Table "Like_Unlike"

-   Crée une migration pour effectuer des posts

```
php artisan make:migration create_likes_table
```

Son contenu initial est le suivant :

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
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
        Schema::dropIfExists('likes');
    }
}

```

-   Modification du contenu pour faire correspondre nos likes à nos posts et à nos utilisateurs

    -   Ajout d'un champ faisant la liaison avec l'id de l'utilisateurs de la table "users".
    -   Ajout d'un champ faisant la liaison avec le post de l'utilisateurs de la table "posts".

```php
  $table->integer('user_id')->unsigned();
  $table->integer('post_id')->unsigned();
```

-   Lancement de la migration

```
php artisan migrate
```

### B. Création du Model /Modification du Model "User.php"

1. Création du model "Like.php" :

```
php artisan make:model Likes
```

Le model permet la liaison entre les différentes tables mais aussi de vérifier que la valeur correspond bien à ce que le champs demandent.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
}

```

2. Nous avons donc besoin ici de rajouter les liaisons entre nos likes, nos utilisateur et nos posts pour cela écrire la fonction suivante dans notre model "User.php" :

-   Affiche les "j'aime" de l'utilisateur connecté sur les posts qu'il a aimé pour qu'il ne puisse pas aimer 2 fois un post ou ne plus aimer un post.

```php
  public function isLike(Post $post){
    return $post->hasMany(Like::class,'post_id')->where('user_id', $this->id)->count();
    }
```

3. Nous avons donc besoin ici de rajouter les liaisons entre nos likes et nos posts pour cela écrire la fonction suivante dans notre model "Post.php" :

-   Affiche le compteur de "j'aime" des différents posts que les différents utilisateurs ont aimés.

```php
   public function postLike(){
    return $this->hasMany(Like::class,'post_id');
    }
```

Nos modèles sont désormais prêt !

### C. Gestion des J'aime / J'aime pas dans le controller

Les "J'aime / J'aime pas" se géreront dans la home, nous utiliserons donc le controller correspondant au post ici "PostController".

Pour ce qui est des fonctions de j'aime et j'aime pas cela se gérera dans le profil "ProfilController".

-   Ajouter donc dans votre controller les fonctions suivantes :

1. Fonction d'ajout d'un like

```php
    public function like($id, Post $post)
    {
        $user_id = Auth::user()->id;
        $like_post = $post->where('id', $id)->first();

        $like = new Like;
        $like->user_id = $user_id;
        $like->post_id = $like_post->id;
        $like->save();

        return redirect()->back()->withOk("Vous aimez la publication « " . $like_post->text . " ». ");
    }
```

2. Fonction de suppression d'un like soit unlike

```php
    public function unlike($id, Like $like, Post $post)
    {
        $user_id = Auth::user()->id;
        $post_id = $post->where('id', $id)->first();

        //where == request
        $unlike = $like
            ->where('user_id', $user_id)
            ->where('post_id', $post_id->id)
            ->first();
        //dd($unlike);
        $unlike->delete();

        return redirect()->back()->withOk("Vous n'aimez plus la publication «" . $post_id->text . " ».");
    }
```

N'oubliez pas d'importer la référence à la table

```php
use App\Like_Unlike;
```

### D. Gestion des routes

-   Ajouter les ligne suivante pour que la liaison entre vos boutons dans la vue et votre controller se fassent

```php
Route::get('/home/{id}/like', 'PostController@like')->name('post.like');
Route::get('/home/{id}/unlike', 'PostController@unlike')->name('post.unlike');
```

### E. Vue

#### \_\_Boutons

-   Création des boutons pour procéder au j'aime et j'aime pas des différents posts sur la page de profil des utilisateurs "profil.blade.php" et aussi sur la page "home.blade.php" c'est-à-dire la où nos posts apparaissent.

1. Bouton d'action d'ajout, "J'aime" :

```php
    <a href="{{route('post.like', $post->id)}}"
        class="text-decoration-none text-secondary w-50">
        <div class="d-flex m-0 justify-content-center">
            <img src="/img/unlike_post.png" alt="Aimer un post" width="18"
                height="18" class="my-auto">
            <p class="px-1 m-0 my-auto">J'aime</p>
        </div>
    </a>
```

2. Bouton d'action de suppression du j'aime, "J'aime pas" :

```php
    <a href="{{route('post.unlike', $post->id)}}"
        class="text-decoration-none text-secondary w-50 d-none">
        <div class="d-flex m-0 justify-content-center">
            <img src="/img/like_post.png" alt="Aimer un post" width="18" height="18"
                class="my-auto">
            <p class="px-1 m-0 my-auto text-primary">J'aime</p>
        </div>
    </a>
```

#### \_\_Condition

-   Condition permettant d'afficher ou j'aime pour aimer le post ou j'aime pas pour ne plus aimer le post.

1. Si pas aimé alors "J'aime".
2. Si aimé alors "J'aime" mais activé.

```php
@if(!Auth::user()->isLike($post))
    <a href="{{route('post.like', $post->id)}}"
        class="text-decoration-none text-secondary w-50">
        <div class="d-flex m-0 justify-content-center">
            <img src="/img/unlike_post.png" alt="Aimer un post" width="18"
                height="18" class="my-auto">
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
```

#### Édition du bloc des posts pour l'intégration des "J'aime / J'aime pas".

Ce bloc accueil actuelement le texte contenu dans les publications. Dans cette `<div>`de contenu "body" nous y ajouter le compteur de j'aime avec la fonction précédemment crée, mais aussi la possibilité d'aimer la publication, de ne plus l'aimer et enfin d'anticiper pour les futurs commentaires des publications.

-   Pour ce faire, nous devons donc modifier le bloc précédemment crée :

```php
<div class="card-body px-2 py-1">
    <p class="m-0 text-info" style="font-size:16px;">
        {{$post->text }}
    </p>
    <!--Barre de séparation-->
    <div class="mx-2">
        <hr class="m-1 p-
                0">
    </div>
    <!--Icone avec compteur de j'aime-->
    <div class="d-flex m-0">
        <img src="/img/likes.png" alt="Icone nombre de j'aime" width="18" height="18"
            class="my-auto">
        <p class="px-1 m-0 my-auto text-muted">{{$post->postLike->count()}}</p>
    </div>
    <!--Barre de séparation-->
    <div class="mx-2">
        <hr class="m-1 p-
                0">
    </div>
    <!--Condition d'affichage du j'aime ou j'aime pas-->
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
        <!--Anticipation pour les futurs commentaires-->
        <a href="" class="text-decoration-none text-secondary w-50 ">
            <div class="d-flex m-0 justify-content-center">
                <img src="/img/coms.png" alt="Aimer un post" width="18" height="18"
                    class="my-auto">
                <p class="px-1 m-0 my-auto">Commenter</p>
            </div>
        </a>

    </div>

</div>
```

### F. Rendu visuel

#### Profil - Partie Journal avec j'aime / j'aime pas

![Profil j'aime/j'aime pas](screens/FBL-page-profil-journal.png)

#### Page d'accueil avec j'aime / j'aime pas
