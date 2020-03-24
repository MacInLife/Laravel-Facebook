## XI. Demandes d'amis

Les demandes d'amis se feront directement sur votre profil ou par recherche d'un profil utilisateur ou encore sur la timeline.

Vos demandes d'amis en attente et vos amis seront eux affichés uniquement sur votre profil. Vous aurez la possibilité d'accepter une demande d'amis ou de la refuser et vous pourrez également supprimer un de vos amis.

### A. Création de la Migration/Table "Amis"

-   Crée une migration pour effectuer des posts

```
php artisan make:migration create_amis_table
```

Son contenu initial est le suivant :

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amis', function (Blueprint $table) {
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
        Schema::dropIfExists('amis');
    }
}
```

-   Modification du contenu pour faire correspondre nos amis et nous même

    -   Ajout d'un champ "amis_id" faisant la liaison avec l'id de l'utilisateurs de la table "users" qui reçoit la demande.
    -   Ajout d'un champ "user_id" faisant la liaison avec l'id de l'utilisateurs de la table "users" qui fait la demande.
    -   Ajout d'un champ booléen "active" qui gère la demande d'amis

        -   Si "demande d'amis" alors création de la liaison dans la table avec le "active = 0"
        -   Si active = 0 alors "demande d'amis en attente".
        -   Si active = 1 alors "demande d'amis accépté".

        Pour la suppression d'amis, cela supprimera directement la liaison.

```php
    $table->integer('user_id')->unsigned();
    $table->integer('amis_id')->unsigned();
     $table->boolean('active');
```

-   Lancement de la migration

```
php artisan migrate
```

### B. Création du Model /Modification du Model "User.php"

1. Création du model "Amis.php" :

```
php artisan make:model Amis
```

Le model permet la liaison entre les différentes tables mais aussi de vérifier que la valeur correspond bien à ce que le champs demandent.

2. Nous avons donc besoin ici de rajouter la liaison entre nos amis et notre utilisateurs, pour cela écrire la fonction suivante dans notre model "User.php" :

```php
  public function amis(){
        //Many To Many - withPivot = recup booleen
        return $this->belongsToMany(\App\Tag::class)->withPivot('active')->withPivot('created_at');
    }
    public function amisActive()
    {
        return $this->belongsToMany(\App\Tag::class)
            ->withPivot('active')->withPivot('created_at')
            ->wherePivot('active', true);
    }
```

Nos modèles sont désormais prêt !

### B. Gestion des amis dans le controller

Comme expliquer précédemment les demandes d'amis se géreront dans le profil, nous utiliserons donc le controller correspondant au profil ici "ProfilController".
