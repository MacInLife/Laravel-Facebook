## X. Voir ses posts sur son profil

### A. Partie de la vue des posts

-   Modification de l'affichage des posts, remplacer la partie des publications comme suit :

```php
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
                        <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                                src="{{Auth::user()->avatar}}" alt="" width="40"></div>
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
        <div class="card-header">Fil d'actualité</div>
        <div class="card-body">Aucune publication</div>
    </div>
    @else
    @foreach ($posts as $post)
    @if($post->user->name === $user->name)
    @csrf
    <div class="card my-2">
        <div class="card-header d-flex my-auto p-2">
            <div class="mr-2"><img style="border-radius:50%; border:1px solid #DADDE1;"
                    src="{{$post->user->getAvatar()}}" alt="" width="40"></div>
            <div class="mr-auto">
                <p class="my-auto">{{$post->user->firstname}} {{$post->user->name}}</p>
                <p class="text-muted mr-2 my-auto text-secondary font-italic">
                    {{$post->created_at->locale('fr_FR')->diffForHumans()}}</p>
            </div>
            <form action="{{route('destroy.post', $post->id)}}" method="DELETE" id="myform"
                class="p-2">
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
```

### B. ProfilController

-   Ajout de la ligne d'affichage de ses posts a la fonction index :

```php
 $posts = $post->orderBy('id', 'DESC')->get();
```

N'oublier pas d'ajouter la référence dans l'appel de la fonction, ainsi que l'import

```php
//Import des posts
use App\Post;
//Ajout des posts a notre fonction
public function index($slug, User $user, Post $post)
```

-   Code entier :

```php
use App\Post;
    public function index($slug, User $user, Post $post)
    {
        $u = $user->wherePseudo($slug)->first();

        if (!$u) {
            $u = $user->whereId($slug)->first();
            if (!$u) {
                return redirect('/', 302);
            }
        }
        $posts = $post->orderBy('id', 'DESC')->get();

        //Retourne la view des posts
        return view('/auth/profil', [ 'user' => $u , 'posts' => $posts]);
    }
```

### C. Rendu affichage de ses posts

![FBL-page-profil-posts.png](FBL-page-profil-posts.png)
