## XIII. Commentaire d'un post

### A. Modification de la Migration/Table "Post"
-   Modification du contenu pour ajouter la gestion de nos commentaires
-   Fichier :  "*année_mois_date_heure_create_posts_table.php*"
    -   Ajout d'un champ "parent_id" faisant la liaison avec l'id du post commenté de la table "posts".

```php
    $table->integer('parent_id')->nullable()->unsigned();
```

-   Lancement de la migration
`php artisan migrate`

### B. Modifications des Vues

Nous allons ajouter l'affichage de nos commentaires (réponse à un post) sur notre Home page et aussi sur notre profil.
- Dans un premier temps, nous modifierons la page Home "***home.blade.php***" pour y ajouter nos commentaires puis dans un deuxième temps, nous modifierons la page de profil "***profil.blade.php***"
- Tout en sachant que ces deux pages ont chacun un controller lui corespondant : ***home.blade.php*** > ***PostController.php*** et ***profil.blade.php*** > ***ProfilController.php*** que nous modifierons également dans un prochain temps pour y ajouter la gestion des données liés à l'affichage de nos commentaires également.

1. Modification de la page Home (Timeline)

boucle des post
    > boucle de com's

2. Modification de la page Profil
### C/D. Modification du Model "User.php"

    $post->replies


    $post-pas parent
    //Scope = alias pour eviter where null parent_id
    public function scopeNotReply($query){
        return $query->whereNull('parent_id')
    }

    public function replies(){
    return $this->hasMany(Post::class, 'parent_id');
    }
    parent_id = id du post

### C/D. Modifications des Controllers
Comme expliquer précedement, nous allons modifier les fichiers suivants :  ***PostController.php*** et  ***ProfilController.php*** pour récupérer les données des commentaires à afficher.

1. Modification de PostController

Ajout parent_id sur Post
si parent_id = null = alors post 
sinon parent_id = user_id alors com's

2. Modification de ProfilController





