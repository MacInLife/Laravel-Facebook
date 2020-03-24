# ![Logo Laravel Facebook](docs/logo-laravel-facebook.png)

Créer un réseau social clone de Facebook en utilisant le framework PHP Laravel.

## Tutorial Étapes

-   **I. [Création du projet](docs/creation-projet.md)** > _Projet initial vide_

-   **II. [Création d'un repo git](docs/creation-repo-git.md)** > _Gestion du versionning de fichier_

-   **III. [Page de connexion](docs/page-connexion.md)** > _Modification de page d'accueil LARAVEL en page de connexion pour Facebook_

-   **IV. [Champs "prénom" et "avatar"](docs/firstname-and-avatar.md)** > _Ajout du champ prénom à notre formulaire d'inscription, et ajout de l'avatar pour l'intégration futur de celui-ci._

-   **V. [Intégration de la Gestion des erreurs en français](docs/gestion-erreur-fr.md)** > _Tester vos formulaires en faisant des erreurs pour vérifier la bonne application._

-   **VI. [Barre de navigation](docs/barre-navigation.md)** > _Modification de l'apparence de la barre de navigation de LARAVEL après connexion, par une barre de navigation ressemblante à celle de Facebook, ainsi qu'un sous-menu correspondant._

-   **VII. [Page Compte](docs/page-compte.md)** > _Création de la page de gestion du compte avec le controller et les routes associés "AccountController" (modification données du compte, ajout d'un nom d'utilisateur \[migration], suppression avatar/compte)._

-   **VIII. [Page Profil](docs/page-profil.md)** > _Création de la page profil avec le controller et les routes associés "ProfilController", possibilité de modifier son avatar et sa photo de couverture_

-   **IX. [Création des posts](docs/posts.md)** > _Création des posts / commentaires avec la migration, les ressources du controller, le model et les routes associés "PostController" (Ajout/Vision/Suppression de ses propres posts sur son fil d'actualité (home)._

-   **X. [Voir ses posts sur son profil](docs/page-profil-posts.md)** > _Possibilité de voir ses propres posts sur son profil et de les supprimer également "ProfilController". (Gestion de la vue et du controller)._

## Grilles des Vues

|                                                                                                                       |                                                                                          |                                                                                                                |
| :-------------------------------------------------------------------------------------------------------------------: | :--------------------------------------------------------------------------------------: | :------------------------------------------------------------------------------------------------------------: |
|                           ![docs/localhost.png](docs/localhost.png) Page de base de LARAVEL                           |     ![docs/PHPMyAdmin-CreateBDD.png](docs/PHPMyAdmin-CreateBDD.png) Création de BDD      |                  ![docs/Base-register.png](docs/Base-register.png) Page d'inscription LARAVEL                  |
|                         ![docs/Base-login.png](docs/Base-login.png) Page de connexion LARAVEL                         |        ![docs/Base-logged_in.png](docs/Base-logged_in.png) Page d'accueil LARAVEL        |                 ![Logo Laravel Facebook](docs/logo-laravel-facebook.png) Logo Laravel Facebook                 |
|                     ![docs/FB-welcome.png](docs/FB-welcome.png) Page de connexion/inscription FBL                     |    ![FBL-barre-navigation.png](docs/FBL-barre-navigation.png) Barre de navigation FBL    |                     ![docs/FBL-page-compte.png](docs/FBL-page-compte.png) Page Compte FBL                      |
|              ![docs/profil-edit-avatar-cover.png](docs/profil-edit-avatar-cover.png) Page profil initial              | ![docs/FBL-page-home.png](docs/FBL-page-home.png) Page Home (accueil) - Étape 1 initial  | ![docs/FBL-page-home-publication.png](docs/FBL-page-home-publication.png) Page Home - Étape 2 avec publication |
| ![docs/FBL-page-home-publication.png](docs/FBL-page-home-publication.png) Page Home - Étape 2 suppression publication |        ![docs/FBL-post-supp.png](docs/FBL-post-supp.png) Page Home - Étape 3 post        |                 ![docs/FBL-post-alert.png](docs/FBL-post-alert.png) Page Home - Étape 3 alert                  |
|               ![docs/FBL-page-home-supp.png](docs/FBL-page-home-supp.png) Page Home - Étape 3 supprimé                | ![docs/FBL-page-profil-posts.png](docs/FBL-page-profil-posts.png) Page profil avec posts |                                                       ?                                                        |
