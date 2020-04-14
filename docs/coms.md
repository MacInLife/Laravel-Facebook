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

1. Modification de la page Home (Timeline)

boucle des post
    > boucle de com's

2. Modification de la page Profil
### C/D. Modification du Model "User.php"

    $post->coms


    $post-pas parent
    //Scope = alias pour eviter where null parent_id
    public function scopeNotReply($query){
        return $query->whereNull('parent_id')
    }

    public function coms(){
    return $this->hasMany(Post::class, 'parent_id');
    }
    parent_id = id du post

### C/D. Création / Modifications des Controllers
Comme expliquer précedement, nous allons modifier les fichiers suivants :  ***PostController.php*** et  ***ProfilController.php*** pour récupérer les données des commentaires à afficher.
1. Création du ComController
   `php artisan make:controller ComController`
   
2. Modification de PostController

Ajout parent_id sur Post
si parent_id = null = alors post 
sinon parent_id = user_id alors com's

3. Modification de ProfilController





