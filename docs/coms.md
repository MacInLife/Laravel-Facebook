## XIII. Commentaire d'un post

### A. Modification de la Migration/Table "Post"

-   Modification du contenu pour ajouter la gestion de nos commentaires
-   Fichier :  "*année_mois_date_numero_create_posts_table.php*"
    -   Ajout d'un champ "parent_id" faisant la liaison avec l'id du post commenté de la table "posts".

```php
    $table->integer('parent_id')->nullable()->unsigned();
```

-   Lancement de la migration
`php artisan migrate`

Si votre terminal vous répond, "**Nothing to migrate**".<br>
Cela signifie qu'il ne voit pas les modifications faites sur celle-ci, pour cela plusieurs solutions.<br>
Pour ma part j'ai choisi la *solution 3* car nous sommes à la fin du projet et que je ne voulais pas réinitialiser toutes mes données entrées.

#### Solution 1 : 
Relancer notre migration en revenant en arrière sur la table (`php artisan migrate:rollback` puis `php artisan migrate`) mais vous risquez de perdre les données entrées.

#### Solution 2 : 
Faire un `php artisan migrate:refresh` mais cela réinitialiserais toutes nos tables à zéro.

#### Solution 3 : 
Modifier la table "posts" en créant une migration non de création mais de modification.
1. Nous créons notre migration avec une petite variante comme suit :
   `php artisan make:migration add_parent_id_to_posts_table --table=posts`

La migration que nous venons de créer ressemble à ceci :

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentIdToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
}
```

2. Nous allons maintenant y ajouter les données qui nous intéresse :
   Ces données s'ajoute dans la fonction up() pour pouvoir pousser nos données à la BDD.
   ```php
    $table->integer('parent_id')->nullable()->unsigned();
    ```
    Celle-ci correspond à la ligne que nous voulions ajouter à la table posts précédemment.

3. Relancer notre migration
`php artisan migrate`

Le terminal doit désormais vous répondre les lignes suivantes :
- **Migrating: année_mois_jours_numero_add_parent_id_to_posts_table**
- **Migrated:  année_mois_jours_numero_add_parent_id_to_posts_table (0.09 seconds)**

### B. Modifications des Vues

Nous allons ajouter l'affichage de nos commentaires (réponse à un post) sur notre Home page et aussi sur notre profil.
- Dans un premier temps, nous modifierons la page Home "***home.blade.php***" pour y ajouter nos commentaires puis dans un deuxième temps, nous modifierons la page de profil "***profil.blade.php***"
- Tout en sachant que ces deux pages ont chacun un controller lui corespondant : ***home.blade.php*** > ***PostController.php*** et ***profil.blade.php*** > ***ProfilController.php*** que nous modifierons également dans un prochain temps pour y ajouter la gestion des données liés à l'affichage de nos commentaires également.

1. Modification/Intégration de la page Home (Timeline) & Profil
 
<details>
<summary>Code concernant la fenêtre de saisie des commentaires (*input*)</summary>

```php
 <!--Partie créations des commentaires-->
 <div class="form-group m-2 comment">
 <!--If de gestions des erreurs-->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
     <!--Formulaire d'envoi du commentaire-->
    <form method="post" action="{{route('createCom.com')}}">
     <!--Input invisible qui récupère l'id du post commenter (post_parent) -->
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
```
</details>

<details>
<summary>Code concernant la boucle d'affichage des commentaires</summary>

```php
     <!--Partie boucle d'affichage des commentaires-->
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
        <form action="{{route('destroyCom.com', $com->id)}}" method="DELETE" class="pl-2">
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
```
</details>

<details>
<summary>Un peu de CSS pour harmoniser</summary>

```css
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
        /* display: none;*/
        transition: all 1s ease-in-out;
    }

    .comment.active {
        display: block;
        transition: all 1s ease-in-out;
    }

</style>
@endsection
```
</details>

Vous pouvez copier/coller ce code dans les deux pages concerner.

### C. Modification du Model "Post.php"
Nous avons donc besoin ici de rajouter la liaison entre nos posts et notre commentaire, pour cela écrire la fonction suivante dans notre model :
```php
    public function coms(){
        return $this->hasMany(Post::class, 'parent_id');
        //parent_id = id du post
    }
```

### D. Création / Modifications des Controllers

Comme expliquer précedement, nous allons modifier les fichiers suivants :  ***PostController.php*** et  ***ProfilController.php*** pour récupérer les données des commentaires à afficher. Mais nous allons aussi crée un controller ***ComController*** pour gérer l'ajout et la suppression de nos commentaires.

1. Création du ComController
   `php artisan make:controller ComController`

2. Création de la fonction create :
   Cette fonction est casiment la même que pour la création des posts avec le paramètres "*parent_id*" en plus
```php
public function createCom(Post $post, Request $request)
    {
        //Validation
        $validate = $request->validate([
            'text' => 'required',
        ]);
        //Création
        $post = new Post;
        $post->text = $request->text;
        $post->user_id = Auth::user()->id;
        $post->parent_id = $request->parent_id;

        //Sauvegarde du post tweet
        $post->save();

        //Redirection
        return redirect::back();
    }
```

3. Création de la fonction delete :
   Cette fonction est identique à celle utilisé pour la suppression des posts
```php
 public function destroyCom($id, Post $post)
    {
        //Trouve le post de l'utilisateur concerné
        $p = $post->find($id);
        //Si t'es authentifier alors il supprime
       if (Auth::check()) {
        $p->delete($id);

        //
        return redirect::back()->withOk("La publication «" . $p->text . "» a été supprimé.");
        }
    }
```

4. Modification de PostController
Dans la fonction qui affiche les posts, nous devons lui préciser d'afficher que ceux pour lequel "*parent_id*" est égale à null pour ne pas qu'il affiche les publications et les commentaires aux mêmes niveaux.

 //Réflexion personnel<br>
- Ajout parent_id sur Post
- si parent_id = null = alors post 
- sinon parent_id = user_id alors com's

Dans la fonction index ()
```php
   //Post de la personne connecter et des amis de la personne connectée avec parent_id = null
    $posts = $post
    ->whereIn('user_id', Auth::user()->amisActive()->pluck('amis_id'))->whereNull('parent_id')
    ->orWhere('user_id', Auth::user()->id)->whereNull('parent_id')
    ->with('user')
    ->orderBy('id', 'DESC')
    ->paginate(4);
```


5. Modification de ProfilController
Dans la fonction qui affiche les posts, nous devons lui préciser d'afficher que ceux pour lequel "*parent_id*" est égale à null pour ne pas qu'il affiche les publications et les commentaires aux mêmes niveaux.

Dans la fonction index ()
```php
    $posts = $post->where('user_id', $u->id)->whereNull('parent_id')->orderBy('id', 'DESC')->get();
```


### E. Création des Routes
-   Ajouter la ligne suivante pour que la liaison entre votre vue et votre controller se fassent

```php
//Route de la méthode répondre à un post par un commentaire (création)
Route::post('/', 'ComController@createCom')->middleware('auth')->name('createCom.com');
//Route de la méthode delete un commentaire (suppression)
Route::get('/com/{id}', 'ComController@destroyCom')->middleware('auth')->name('destroyCom.com');
```

### F. Rendu visuel
![Page Home - Com's](/screens/FBL-page-home-coms.png)
![Page Profil - Journal - Com's](/screens/FBL-page-profil-journal-coms.png)