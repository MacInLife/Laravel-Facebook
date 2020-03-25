## VI - Barre de navigation et gestion du menu après connexion

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
![screens/FBL-barre-navigation.png](screens/FBL-barre-navigation.png)
