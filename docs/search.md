## Barre de Recherche, Petit Logo & Favicon

Rechercher un utilisateurs dans la barre de recherche

### A. Création de la barre de recherche 

- La barre de recherche se trouve sur toutes les pages de notre application dans notre barre de navigation.

Celle-ci se trouve dans notre fichier _**"app.blade.php"**_. Nous allons donc encore modifier ce fichier pour y ajouter celle-ci et aussi changer notre logo au besoin ou autres...

1. Formulaire à ajouter pour crée la barre de recherche
```php
<form class="form-inline position-relative w-100" action="{{ url('search') }}" method="GET">
    <input class="form-control mr-sm-2" type="search" placeholder="Rechercher"
        aria-label="Search">
    <button class="btn btn-outline-primary" type="submit"><svg class="svg-search" width="16"
            height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
                d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
        </svg></button>
</form>
```

Personnellement je l'ai ajouter dans la barre de navigation dans le `<ul>` suivant :
```php
 <!-- Left Side Of Navbar -->
<ul class="navbar-nav mr-auto pl-2">
</ul>
```
### B. Création du controller
-   Tout d'abord, nous créons notre controller sans les références car nous allons juste faire un affichage

```
php artisan make:controller SearchController
```

1. Voici le controller crée :
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
}
```

2. Ajouter la fonction de récupération des données recherchés
```php
    public function index(User $user)
    {
        $user = User::all();

        $search = \Request::get('search');  

        $users = User::where('name','=','%'.$search.'%')
            ->orderBy('name')
            ->paginate(20);

        return view('search',compact('users'))->withuser($user);

    }
```

### C. Création de la vue
- La vue accueillera les résultats de la recherche.
Dans le dossier de views, crée le fichier _**"search.blade.php"**_

1. Récupérer le template de notre application
```php
<!--Récupération du template "lajouts.app" qui corespond au fichier "app.blade.php" -->
@extends('layouts.app')

@section('title')
<!--Ici insérer votre titre d'onglet de page -->
Laravel Facebook - Recherche
@endsection

@section('style')
<!--Ici insérer votre style CSS propre à la page -->
@endsection
@section('content')
<!--Ici insérer votre contenu de recherche -->
@endsection
```

2. Ajouter le contenu de notre recherche
```php
 @foreach($user as $users)
                <th scope="row">1</th>
                <td><a href="{{ url('/user').'/'.$users->id }}">show</a></td>
                    <td>{{$users->name}}</td>
                <td>{{$users->city}}</td>
                <td>{{$users->phone}}</td>
                <td>{{$users->street}}</td>
                <td>{{$users->national_id}}</td>
                <td>{{$users->name}}</td>

            </tr>
@endforeach
```
### D. Création de la route

Ajouter la ligne suivante dans "web.php"
```php
Route::get('/search', 'SearchController@index')->name('search');
 ```

### E. Rendu visuel

## Petit Logo

Changement du grand logo par le petit logo après connexion
```php
  <a class="navbar-brand p-0 m-0" href="{{ url('home') }}">
        <img class="m-0" src="/img/logo-laravel-facebook.svg" alt="Logo Laravel Facebook" width="43"
            height="43">
    </a>
```

## Favicon

Ajouter la ligne suivante pour mettre une image dans l'onglet de votre navigateur, bien sûre le lien "href" de l'image doit correspondre à l'endroit ou vous avez stocker votre image.

```html
<link rel="shortcut icon" type="image/png" href="/img/logo-laravel-facebook.svg" />
```