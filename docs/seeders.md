## Intégration de Seeders (fausse données) USER + POST

### A - Création des Seeders pour les utilisateurs

-   Création d'un seeder de fausse données pour les utilisateurs

`php artisan make:seed UsersTableSeeder`

Le fichier en question "UsersTableSeeder.php" se crée dans le dossier "database/seeds" avec la composition suivantes :

```php

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }
}
```

-   Modifier le seeder pour y ajouter les fausses données qui nous intéresse :

    1. Ajouter la méthode Faker dans les "use" (import)

    ```php
    //Add use Faker
    use Faker\Factory as Faker;
    ```

    1. Ajouter l'appel du modèle de gestion des utilisateurs "User.php"

    ```php
    use App\User;
    ```

    1. Dans la fonction run, y ajouter les attributs avec les fausses données

    ```php
    //Permet de générer des fausses données 'fr_FR' en français
        $faker = Faker::create('fr_FR');

        //Boucle de création des faux users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->name = $faker->name();
            $user->firstname = $faker->firstName();
            $user->pseudo = $faker->userName();
            $user->email = $faker->email();
            $user->password = Hash::make($faker->password());
            $user->save();
        }
    ```

-   Une fois ce fichier créer et modifier correctement, il faut l'appeler dans le fichier "DatabaseSeeder.php"

    `$this->call(UsersTableSeeder::class);`

-   Lancer la création des fausses données :

    `php artisan db:seed`

Vous pouvez vérifier que vos données ont été crée dans votre BDD !

### B - Création des Seeders pour les publications et commentaires

-   Création d'un seeder de fausse données pour les publications des utilisateurs (post)

`php artisan make:seed PostsTableSeeder`

Le fichier en question "PostsTableSeeder.php" se crée dans le dossier "database/seeds" avec la composition suivantes :

```php

<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }
}
```

-   Modifier le seeder pour y ajouter les fausses données qui nous intéresse :

    1. Ajouter la méthode Faker dans les "use" (import)

    ```php
    //Add use Faker
    use Faker\Factory as Faker;
    ```

    2. Ajouter l'appel du modèle de gestion des posts "Post.php"

    ```php
    use App\Post;
    ```

    3. Dans la fonction run, y ajouter les attributs avec les fausses données

    ```php
      //Permet de générer des fausses données 'fr_FR' en français
         $faker = Faker::create('fr_FR');

         //Boucle de création des faux posts
         for ($i = 0; $i < 10; $i++) {
             $post = new Post();
             $post->text = $faker->text();
             $post->user_id = $faker->numberBetween(1, 9);
             $post->save();
         }
    ```

-   Une fois ce fichier créer et modifier correctement, il faut l'appeler dans le fichier "DatabaseSeeder.php"

    `$this->call(PostsTableSeeder::class);`

-   Lancer la création des fausses données :

    `php artisan db:seed`

Vous pouvez vérifier que vos données ont été crée dans votre BDD !




