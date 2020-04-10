<h1>
    <img src="public/img/logo-laravel-facebook-blue.svg" alt="Logo Laravel Facebook" width="100" height="auto"> 
    <img  class="bg-dark" style="background:black!important; background-color:black!important;" src="docs/screens/logo-laravel-facebook.png" alt="Logo Laravel Facebook" width="auto" height="auto"> 
    <img src="public/img/logo-laravel-facebook.svg" alt="Logo Laravel Facebook" width="100" height="auto"> 
    <img src="public/img/logo-laravel-facebook-orange-blue.svg" alt="Logo Laravel Facebook" width="100" height="auto">
</h1>

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

-   **IX. [Création des posts](docs/posts.md)** > _Création des posts avec la migration, les ressources du controller, le model et les routes associés "PostController" (Ajout/Vision/Suppression de ses propres posts sur son fil d'actualité (home)._

-   **X. [Voir ses posts sur son profil](docs/page-profil-posts.md)** > _Possibilité de voir ses propres posts sur son profil et de les supprimer également "ProfilController". (Gestion de la vue et du controller)._

-   **XI. [Demandes d'amis](docs/amis.md)** > _Création de la demande d'amitié avec la migration, le model et la modification du controller "ProfilController" qui gérera nos demandes. (Ajouter un amis, Accepter ou Refuser une demande d'amis, Suppression d'un amis)._

-   **XII. [J'aime/J'aime pas](docs/like-unlike.md)** > _Aimer un post, afficher le compteur et ne plus aimer un post, mise à jour du compteur._

-   **XIII. [Répondre à un post](docs/rep-posts.md)** > _Répondre à un post du post parents, aimer ce post._

-   **XIV. [Barre de Recherche](docs/search.md)** > _Rechercher un utilisateurs dans la barre de recherche._

-   PS : [Générateur de fausses données pour faire fonctionner l'application rapidement.](docs/seeders.md)

## Grilles des Vues

|                                                                                                                                                                     |                                                                                                                                                                     |                                                                                                                                      |
| :-----------------------------------------------------------------------------------------------------------------------------------------------------------------: | :-----------------------------------------------------------------------------------------------------------------------------------------------------------------: | :----------------------------------------------------------------------------------------------------------------------------------: |
|                                          ![docs/screens/localhost.png](docs/screens/localhost.png) Page de base de LARAVEL                                          |                                   ![docs/screens/PHPMyAdmin-CreateBDD.png](docs/screens/PHPMyAdmin-CreateBDD.png) Création de BDD                                   |                     ![docs/screens/Base-register.png](docs/screens/Base-register.png) Page d'inscription LARAVEL                     |
|                                        ![docs/screens/Base-login.png](docs/screens/Base-login.png) Page de connexion LARAVEL                                        |                                     ![docs/screens/Base-logged_in.png](docs/screens/Base-logged_in.png) Page d'accueil LARAVEL                                      |                        ![Logo Laravel Facebook](docs/screens/logo-laravel-facebook.png) Logo Laravel Facebook                        |
|                                        ![Logo Laravel Facebook](public/img/logo-laravel-facebook.svg) Logo réduit LFB blanc                                         |                                    ![Logo Laravel Facebook bleu](public/img/logo-laravel-facebook-blue.svg) Logo réduit LFB bleu                                    |          ![Logo Laravel Facebook couleur FBL](public/img/logo-laravel-facebook-orange-blue.svg) Logo réduit au couleur LFB           |
|                                    ![docs/screens/FB-welcome.png](docs/screens/FB-welcome.png) Page de connexion/inscription FBL                                    |                               ![docs/screens/FBL-barre-navigation.png](docs/screens/FBL-barre-navigation.png) Barre de navigation FBL                               |                        ![docs/screens/FBL-page-compte.png](docs/screens/FBL-page-compte.png) Page Compte FBL                         |
|                             ![docs/screens/profil-edit-avatar-cover.png](docs/screens/profil-edit-avatar-cover.png) Page profil initial                             |                               ![docs/screens/FBL-page-home.png](docs/screens/FBL-page-home.png) Page Home (accueil) - Étape 1 initial                               |    ![docs/screens/FBL-page-home-publication.png](docs/screens/FBL-page-home-publication.png) Page Home - Étape 2 avec publication    |
|                ![docs/screens/FBL-page-home-publication.png](docs/screens/FBL-page-home-publication.png) Page Home - Étape 2 suppression publication                |                                     ![docs/screens/FBL-post-supp.png](docs/screens/FBL-post-supp.png) Page Home - Étape 3 post                                      |                    ![docs/screens/FBL-post-alert.png](docs/screens/FBL-post-alert.png) Page Home - Étape 3 alert                     |
|                              ![docs/screens/FBL-page-home-supp.png](docs/screens/FBL-page-home-supp.png) Page Home - Étape 3 supprimé                               |                         ![docs/screens/FBL-page-profil-posts.png](docs/screens/FBL-page-profil-posts.png) Page profil - Journal avec posts                          |        ![docs/screens/FBL-page-profil-journal.png](docs/screens/FBL-page-profil-journal.png) Page profil - Journal avec amis         |
|                   ![docs/screens/FBL-page-profil-amis.png](docs/screens/FBL-page-profil-amis.png) Page profil - Amis gestion utilisateur connecté                   |                ![docs/screens/FBL-page-profil-amis1.png](docs/screens/FBL-page-profil-amis1.png) Page profil - Amis vision utilisateur pas connecté                 | ![Journal d'un utilisateur non amis](docs/screens/FBL-page-profil-journal-add.png) Partie profil - Journal d'un utilisateur pas amis |
| ![Journal d'un utilisateur à qui on a envoyé une demande d'amis](docs/screens/FBL-page-profil-journal-invit_send.png) Page profil - Journal avec invitation envoyée | ![Journal d'un utilisateur à qui on a reçu une demande d'amis](docs/screens/FBL-page-profil-journal-invit_received.png) Page profil - Journal avec invitation reçue |              ![Journal d'un utilisateur amis](docs/screens/FBL-page-profil-amis2.png) Partie profil - Journal d'un amis              |
|                              ![Timeline avec j'aime/j'aime pas](docs/screens/FBL-page-home-like.png) Page home avec j'aime/j'aime pas                               |                             ![Profil avec j'aime/j'aime pas](docs/screens/FBL-page-profil-like.png) Page profil avec j'aime/j'aime pas                              |                        ![Barre de recherche style](docs/screens/FBL-search.png)     Barre de recherche + Logo                        |
|                                ![Barre de recherche vide](docs/screens/FBL-barre-navigation-search-vide.png) Barre de recherche vide                                |                            ![Barre de recherche via Pseudo](docs/screens/FBL-barre-navigation-search1.png) Barre de recherche via Pseudo                            |           ![Barre de recherche via Prénom](docs/screens/FBL-barre-navigation-search.png)    Barre de recherche via Prénom            |


 
 

