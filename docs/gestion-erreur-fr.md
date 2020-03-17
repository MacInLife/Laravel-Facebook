## V - Gestion des erreurs en français

Pour créer un projet avec des messages d'erreur en français, cela est possible grâce à plusieurs méthodes :

-   Voir le lien suivant : [Apprendre à gérer les messages d'erreur](https://www.apprendre-laravel.fr/laraguide/2017-11-18-personnaliser-nos-messages-d-erreur)
-   Plusieurs langues disponibles sur le ".zip" suivant : [Laravel-lang-master.zip](Laravel-lang-master.zip)
-   Ou en ajoutant le dossier "fr" dans le répertoire "ressources/lang/".

Il faut ensuite modifier le fichier "app.php" situé "app/config" en modifiant les lignes suivantes par "fr" au lieu de "en" :

```php
    'locale' => 'fr',
    'fallback_locale' => 'fr',
    'faker_locale' => 'fr_FR',
```

Vous pouvez désormais tester vos formulaires pour vérifier l'application des messages en français.
