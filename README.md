# Facebook Laravel

Créer un réseau social clone de Facebook en utilisant le framework PHP Laravel.

## Tutorial Étapes

-   I. [Création du projet](docs/creation-projet.md) > __Projet initial vide__

-   II. [Création d'un repo git](docs/creation-repo-git.md) > __Gestion du versionning de fichier__

-   III. [Page de connexion](docs/page-connexion.md) > Modification de page d'accueil LARAVEL en page de connexion pour Facebook

IV. Ajout des champs "prénom" & "avatar"

## IV - Ajout du champ prénom

Maintenant que notre code et notre visuel est prêt pour faire fonctionner celui-ci nous avons ajouter un champ prénom qu'il faut également ajouter dans notre BDD.

1. Aller dans le fichier : annnée_mois_date_000000_create_users_table.php<br>
   Qui se situe dans le dossier /database/migrations/

-   Ajouter la ligne concernant le prénom : `$table->string('firstname');`

2. Dans le fichier : User.php<br>
   Qui se situe dans le dossier /app/

-   Ajouter la propriété "firstname" :

```php
protected $fillable = [
      'firstname','name', 'email', 'password',
  ];

```

3. Dans le fichier de création des Users soit ici "RegisterController"<br>
   Qui se situe dans /app/Http/Controllers/Auth/

-   Ajouter la ligne concernant le prénom dans la fonction validator et User::create comme suit :

```php
 protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

     protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
```

4. Lancer la migration pour que les modifications prennent effet :
   `php artisan migrate`

-   Si vous aviez déjà des utilisateurs de crée, votre application plantera car il n'avait pas de prénom.
    Deux solutions: Ajouter le prénom directement en BDD ou supprimer vos utilisateurs en lançant la commande `php artisan migrate:refresh`

5. Tester une inscription utilisateurs, puis une déconnexion, et une connexion via l'utilisateur crée.

## V - Ajout du champ avatar

Nous aurons également besoin d'un avatar pour la suite de notre profil. Nous allons donc ajouter ce champs dans la BDD comme précédemment pour le prénom.

1. Aller dans le fichier : annnée_mois_date_000000_create_users_table.php<br>
   Ce champ est null à la création du compte<br>
   Qui se situe dans le dossier /database/migrations/

-   Ajouter la ligne concernant l'avatar : `$table->string('avatar')->nullable();`

2. Dans le fichier : User.php<br>
   Qui se situe dans le dossier /app/

-   Ajouter la propriété "avatar" et une fonction pour le récuperer :

```php
 protected $fillable = [
        'avatar','firstname','name', 'email', 'password',
    ];

  public function getAvatar() {
  if (!$this->avatar) {
              return '/img/avatar-vide.png';
          }
          return $this->avatar;
  }

```

3. Dans le fichier de création des Users soit ici "RegisterController"<br>
   Qui se situe dans /app/Http/Controllers/Auth/

-   Ajouter la ligne concernant le prénom dans la fonction validator et User::create comme suit :

```php
use Intervention\Image\Facades\Image;

 protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

      protected function create(array $data)
    {
        $request = app('request');

        $path = null;

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = '/uploads/avatars/' . $filename;
            Image::make($avatar)->resize(100, 100)->save(public_path($path));
        }

        return User::create([
            'avatar' => $path,
            'firstname' => $data['firstname'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
```

### Ajout de la bibliothèque "Intervention/image"

1. Pour l'utilisation des avatars, nous avons besoin d'importer une bibliothèque :
   `composer require intervention/image`

2. Dans le fichier "app.php" qui se situe dans /config/

-   Ajouter dans les "providers" la ligne suivante :

```php
 Intervention\Image\ImageServiceProvider::class
```

-   Ajouter dans les "aliases" la ligne suivante :

```php
  'Image' => Intervention\Image\Facades\Image::class
```

3. Lancer la migration pour que les modifications prennent effet :
   `php artisan migrate`
    - Si celui-ci affiche "Nothing to migrate".<br>
      Procéder comme suit, cela permet de revenir une modification en arrière<br>
      `php artisan migrate:rollback`<br>
      et relancer la migration<br>
      `php artisan migrate`

-   Si vous avez coupez votre serveur pour installer la bibliothèque d'image, n'oubliez pas de le relancer avec `php artisan serve`.

4. Tester une inscription utilisateur, puis une déconnexion, et une connexion via l'utilisateur crée.
   Si cela fonctionne toujours mais que vous ne voyez pas l'avatar cela est normal car nous ne l'avons pas encore ajouté à nos vues.

## VI - Gestion des erreurs en français

Pour créer un projet avec des messages d'erreur en français, cela est possible grâce à plusieurs méthodes :

-   Voir le lien suivant : [Apprendre à gérer les messages d'erreur](https://www.apprendre-laravel.fr/laraguide/2017-11-18-personnaliser-nos-messages-d-erreur)
-   Plusieurs langues disponibles sur le ".zip" suivant : [docs/Laravel-lang-master.zip](docs/Laravel-lang-master.zip)
-   Ou en ajoutant le dossier "fr" dans le répertoire "ressources/lang/".

Il faut ensuite modifier le fichier "app.php" situé "app/config" en modifiant les lignes suivantes par "fr" au lieu de "en" :

```php
    'locale' => 'fr',
    'fallback_locale' => 'fr',
    'faker_locale' => 'fr_FR',
```

Vous pouvez désormais tester vos formulaires pour vérifier l'application des messages en français

## VII - Barre de navigation et gestion du menu après connexion

### A. Modification de la barre de navigation

La barre de navigation est native à la connexion de LARAVEL, elle se trouve dans /ressources/views/layouts/<br>
Dans le fichier "app.blade.php"

1. Ajout de la couleur de fond correspondant à celle de Facebook

```php
<nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background:#385898;">
```

Implémenter simplement le style en ligne précédent sur la "nav" existante

2. Ajout du logo de Facebook

```php
   <a class="navbar-brand text-white" href="{{ url('/') }}">
      {{ config('app.name', 'Laravel') }}
      <img class="pl-2 mb-1" src="img/facebook.png" alt="" width="90">
    </a>
```

Ajout de la class "text-write" pour afficher le texte en blanc via Bootstrap.<br>
Implémentation de la balise image avec intégration du logo de Facebook en mode image.

<p>
  Pour ce qui est du style du texte Laravel cela à été modifier dans le fichier "app.css" qui se situe dans /public/css/.
</p>

```css
.navbar-brand {
    display: inline-block;
    padding-top: 0.32rem;
    padding-bottom: 0.32rem;
    margin-right: 1rem;
    font-size: 1.125rem;
    line-height: inherit;
    white-space: nowrap;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, ".SFNSText-Regular",
        sans-serif;
    font-weight: 600;
}
```

Ajout des deux dernières lignes pour la typographie.

3. Ajout de l'avatar & changement nom par prénom & changement couleur texte et puce.

```php
<li class="nav-item dropdown d-flex">
  <a href="#" class="text-decoration-none text-white m-auto d-flex">
    <div class="mr-2" style="width:40px;"><img class="m-auto"
            style="width:40px; border-radius:50%; border:1px solid #DADDE1;"
            src="{{Auth::user()->getAvatar()}}" width="100%" height="100%">
    </div>
    <p class="my-auto"
        style="font-family: system-ui, -apple-system, BlinkMacSystemFont, '.SFNSText-Regular', sans-serif; font-weight:bold;">
        {{ Auth::user()->firstname }}
    </p>
  </a>
  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
      aria-haspopup="true" aria-expanded="false" v-pre>
      <span class="caret" style="color:#1a2a47;"></span>
  </a>
```

### B. Modification du menu et sous-menu de la barre de navigation

1. Déplacement et ajout des sous-menu profil et compte

```php
      <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="navbarDropdown">

        <a class="dropdown-item" href="#">Profil</a>
        <a class="dropdown-item" href="#">Compte</a>
         <div class="m-2"><hr></div>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
            {{ __('Se déconnecter') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST"
            style="display: none;">
            @csrf
        </form>
    </div>
</li>
```

2. Ajout au hover du bleu foncé dans le css et changement de couleur en blanc

```css
.dropdown-item:hover,
.dropdown-item:focus {
    color: #fff;
    text-decoration: none;
    background-color: #385898;
}
```

Votre barre de navigation est désormais prête et ressemblante à celle de Facebook.

## VIII - Création de la page "Compte"

Cette page permettra à l'utilisateur de gérer son compte, c'est-à-dire de pouvoir y modifier les informations le concernant ainsi que de pouvoir supprimer son compte.

### A. Création de la vue (views)

-   La vue portera le nom suivant : account.blade.php
    La page fera appel à la même barre de navigation que le reste des pages déjà crée, avec le même style.<br>
    Pour cela, il suffit de récupérer le template qui s'est crée en même temps que notre projet c'est-à-dire le fichier "app.blade.php" qui se situe dans le dossier /layouts.

Nous appelons donc dans nos fichiers de vue le template permettant de récupérer le même stlye sur chaque page. Cela évite également la répétition du code en ce qui concerne le HTML, le HEAD, le BODY et le MAIN grace au balisage suivantes :

-   Appel du template avec HTML, HEAD, BODY : `@extends('layouts.app')`
-   Appel du conteneur MAIN : `@section('content')`

Cette balise est bien sûre à fermer en fin de page par `@endsection`, tout comme pour annoncer la fermeture du MAIN.

-   Créer un fichier appelé "account.blade.php" dans le dossier "ressources/views/auth" et y appelé les balises nécéssaires.

```php
@extends('layouts.app')
@section('content')
<h1>Page Compte</h1>
@endsection
```

### B. Création du "Controller"

Il permet de gérer les données de la vue

-   Taper la commande suivante : `php artisan make:controller AccountController`

-   Le controller que vous venez de créer avec le nom "AccountController" se situe dans le dossier /app/Http/Controllers.

-   Ajouter les fonctions suivantes pour afficher les données de la page :

```php
  public function show()
{
    return view('/auth/account', ['user' => Auth::user()]);
}

public function account()
{
    return view('/auth/account', array('user' => Auth::user()));
}
```

### C. Création de la "Route" dans "web.php"

Elle permet l'accès à l'url, ce fichier se situe dans le dossier "/routes"

-   Pour créer la route, ajouter cette ligne :

    ```php
    //Route de vision du compte
    Route::get('account', 'AccountController@show')->middleware('auth')->name('account');
    ```

**La page compte est désormais crée, maintenant il faut la remplir avec notre formulaire de modification des données du compte, ainsi que la possibilité de supprimer son compte.**

### D. Contenu de la vue

-   Nous retournons donc écrire notre formulaire dans notre vue "account.bladde.php".

<details>
<summary>Code HTML</summary>

```php
@extends('layouts.app')
<title>Laravel Facebook - Compte</title>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            <div class="card mb-2">
                <div class="card-header">Gestion du compte</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('account.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Changement d'état de l'avatar de base à l'upload -->
                        <div class="mx-auto mb-2" style="width:80px; height:80px;"><img id="user-avatar"
                                class="m-auto rounded img-thumbnail" src="{{Auth::user()->getAvatar()}}" width="100%"
                                height="100%">
                        </div>

                        <!-- Ajout de l'avatar -->
                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>

                            <div class="col-md-6">
                                <input type="file" id="avatar"
                                    class="form-control @error('avatar') is-invalid @enderror" name="avatar"
                                    accept="image/png, image/jpeg" value="{{ old('avatar') }}" autocomplete="avatar"
                                    autofocus onclick="changeImage();" value="">

                                @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Fin ajout de l'avatar -->

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{Auth::user()->name}}" required autocomplete="name" autofocus>

                                @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Pseudo') }}</label>

                            <div class="col-md-6">
                                <input id="pseudo" type="text"
                                    class="form-control @error('pseudo') is-invalid @enderror" name="pseudo"
                                    value="{{Auth::user()->firstname}}" autocomplete="firstname" autofocus>

                                @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Adresse e-mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{Auth::user()->email}}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Enregister les modifications") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Suppression définitive de votre compte</div>
                <div class="card-body">
                    <form action="{{ route('account.destroy', $user->id) }}" method="DELETE">
                        @csrf
                        <!-- method('DELETE') -->
                        <div class="border-bottom mb-2 pb-2">

                            <p>Après avoir validé la suppression de votre compte, vous n'aurez plus accès à celui-ci,
                                ainsi qu'à vos tweets, followers, etc... <span>Vous serez alors rediriger sur notre page
                                    d'accueil !</span></p>
                            <button type="submit" class="btn btn-outline-danger p-2 btn-lg btn-block" onclick="if(confirm('Voulez-vous vraiment supprimer votre compte ?')){
                                            return true;}else{ return false;}">Supprimer mon
                                compte</button>

                        </div>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<style>
    #avatar {
        border: none;
    }

</style>
```

</details>

-   Ajout du lien dans la barre de navigation du fichier **"app.blade.php"**

```php
  <a class="dropdown-item" href="{{ route('account') }}">Compte</a>
```

### E. Gestion des données compte dans le controller

-   Retour dans le controller "AccountController" pour gérer l'update et la suppression

<details>
<summary>Code update & destroy</summary>

```php
public function update(User $user)
    {

    $request = app('request');
    $path = null;

        // Logic for user upload of avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = '/uploads/avatars/' . $filename;
            Image::make($avatar)->resize(100, 100)->save(public_path($path));
            //$user = $user->find($id);
            // $id = Auth::id();
            $user = Auth::user();
            $user->avatar = $path;
            $user->save();
        } else if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = '/uploads/avatars/' . $filename;
            Image::make($avatar)->resize(100, 100)->save(public_path($path));
            //$user = $user->find($id);
            // $id = Auth::id();
            $user = Auth::user();
            $user->avatar = $path;
            $user->name = $request->name;
            $user->firstname = $request->firstname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            $user = Auth::user();
            $user->name = $request->name;
            $user->firstname = $request->firstname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
        }

    return redirect('/account')->withOk("L'utilisateur " . $user->firstname ." ". $user->name . " a été modifié.");
    }

    public function destroy($id, User $user)
    {
    $u = $user->find($id);
    //$posts = $post->where('user_id', Auth::user()->id);
    $u->delete($id);
    //$posts->delete($id);
    return redirect('/')->withOk("L'utilisateur ". $user->firstname ." ". $user->name . " a été supprimé.");
    //->withOk("L'utilisation'" . $u->name . " a été supprimé.");
    }
```

</details>

Lors de la modification de l'avatar, nous stockons cette nouvelle image dans la variable suivantes :

```php
 $path = '/uploads/avatars/' . $filename;
```

Il faut donc crée l'emplacement de se dossier dans votre projet.<br>
Dans le dossier /public, faire un clic droit, nouveau dossier et appeler le "uploads/avatars".<br>
Votre projet est désormais prêt à recevoir les images des utilisateurs.

### F. Ajout des routes update et destroy

```php
//Route d'envoi de la données via l'id vers la BDD pour le update
Route::post('account/{id}', 'AccountController@update')->middleware('auth')->name('account.update');
//Route d'envoi de la données de suppression du compte via l'id en BDD
Route::get('/account/{id}', 'AccountController@destroy')->middleware('auth')->name('account.destroy');

```

### G. Ajout d'un nom d'utilisateur

Voici la marche à suivre pour ajouter le nom d'utilisateur au code que vous venez de faire. <br>
Étapes :

1. Ajouter le champs dans le formulaire de la vue (input pseudo)
2. Ajouter le champs dans notre migration (`$table->string('pseudo')->nullable()->unique();`)
3. Relancer notre migration (`php artisan migrate:rollback` puis `php artisan migrate`)
4. Ajouter notre variable dans le model (User.php)
5. Ajouter la variable dans le controller pour récupérer et gerer la donnée (RegisterController + AccountController)
6. Ajouter si besoin la route correspondante (AccountController@update)

### H. Supprimer son avatar

Possibilité pour l'utilisateur de supprimer son avatar, celui-ci reviendra à l'avatar par défaut.

1. Bouton avec formulaire dans la vue

    **Attention ! On ne peut pas mettre un formulaire dans un autre formulaire !**

```php
 <form action="{{ route('account.destroyAvatar') }}" method="DELETE">
    @csrf
    <!-- method('DELETE') -->
    <div class="border-bottom mb-2 pb-2">
        <button type="submit" class="btn btn-outline-danger p-2" onclick="if(confirm('Voulez-vous vraiment supprimer votre avatar ?')){
                        return true;}else{ return false;}"><img id="user-avatar" class="m-auto"
                src="/img/close.png" width="60" height="60"></button>
    </div>
</form>
```

2. Fonction dans le controller

```php
public function destroyAvatar(User $user)
{

    $u = $user->where('avatar', Auth::user()->avatar);
    $u->update(['avatar'=> '/img/avatar-vide.png']);

    return redirect('/account')->withOk("Votre avatar à bien été supprimé");
}
```

3. Route

    `Route::post('/account', 'AccountController@destroyAvatar')->middleware('auth')->name('account.destroyAvatar');`

## IX - Création de la page "Profil"

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
