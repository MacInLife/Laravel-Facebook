# Ajout des champs "prénom" & "avatar" dans nos formulaires

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
