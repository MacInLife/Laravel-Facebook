## XII. J'aime / J'aime pas

### A. Création de la Migration/Table "Like_Unlike"

-   Crée une migration pour effectuer des posts

```
php artisan make:migration create_like_unlike_table
```

Son contenu initial est le suivant :

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeUnlikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_unlike', function (Blueprint $table) {
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
        Schema::dropIfExists('like_unlike');
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
