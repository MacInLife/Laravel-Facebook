## XI. Demandes d'amis

Les demandes d'amis se feront directement sur votre profil ou par recherche d'un profil utilisateur ou encore sur la timeline.

Vos demandes d'amis en attente et vos amis seront eux affichés uniquement sur votre profil. Vous aurez la possibilité d'accepter une demande d'amis ou de la refuser et vous pourrez également supprimer un de vos amis.

### A. Création de la Migration/Table "Amis"

-   Crée une migration pour effectuer des demandes d'amis

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

2. Nous avons donc besoin ici de rajouter la liaison entre nos amis et notre utilisateurs, pour cela écrire les fonctions suivantes dans notre model "User.php" :

```php
      public function amisDemande(){
        //Relation à plusieurs n à n //table 'amis_dmd', user_id > amis_id
          //Many To Many - withPivot = recup booleen
          return $this->belongsToMany(\App\User::class, 'amis_dmd','user_id', 'amis_id')->withPivot('created_at');
    }

    public function amisActive()
    {
        return $this->belongsToMany(\App\User::class)
            ->withPivot('active')->withPivot('created_at')
            ->wherePivot('active', true);
    }

    public function amisNotActive()
    {
        return $this->belongsToMany(\App\User::class)
            ->withPivot('active')->withPivot('created_at')
            ->wherePivot('active', false);
    }
    public function posts() {
        return $this->hasMany(\App\Post::class, 'user_id');
    }
```

Nos modèles sont désormais prêt !

### B. Gestion des amis dans le controller

Comme expliquer précédemment les demandes d'amis se géreront dans le profil, nous utiliserons donc le controller correspondant au profil ici "ProfilController".

Ajouter donc dans votre controller les fonctions suivantes :

1. Fonction de demande d'amis en attente d'acceptation

```php
public function amis_add($id, User $user)
    {
        $user_id = Auth::user()->id;
        $amis_add = $user->where('id', $id)->first();

        $amis = new Amis;
        $amis->user_id = $user_id;
        $amis->amis_id = $amis_add->id;
        $amis->active = 0;
       //dd($amis);
        $amis->save();

        return redirect()->back()->withOk("La demande d'amis à été envoyé à " . $amis_add->name ." ". $amis_add->firstname ." et est en attente de sa réponse !");
    }

```

2. Fonction de demande d'amis accepté

```php
public function amis_invit($id, Amis $amis, User $user)
    {
        $user_id = Auth::user()->id;
        $amis_invit = $user->where('id', $id)->first();

        //where == request
        $amis = $amis
            ->where('user_id', $user_id)
            ->where('amis_id', $amis_invit->id)
            ->first();
        $amis->active = 1;
        $amis->update();

        return redirect()->back()->withOk("Vous avez accepter la demande d'amis de " . $amis_invit->name ." ". $amis_invit->firstname . " !");
    }
```

3. Fonction de suppression d'un amis

```php
public function amis_delete($id, Amis $amis, User $user)
    {
        $user_id = Auth::user()->id;
        $amis_delete = $user->where('id', $id)->first();

        //where == request
        $amis = $amis
            ->where('user_id', $user_id)
            ->where('amis_id', $amis_delete->id)
            ->first();
           // dd($amis);
        $amis->delete();

        return redirect()->back()->withOk("Vous n'êtes plus amis avec " . $amis_delete->name ." ". $amis_delete->firstname . " !");
    }
```

### C. Vue

-   Création du bouton "Ajouter" pour faire la demande d'amis dans la page profil.

```php
  <!-- Bouton de demande d'amis "Ajouter"-->
@if($user->name != Auth::user()->name)
@if($amis == false)
<a class="text-decoration-none text-dark" href="{{ route('profil.amisAdd', $user->id)}}" role="button"
    aria-pressed="true">
    <div class="border border-dark"
        style="position: absolute;   top: 84%;   left: 90%;  transform: translate(-50%,-50%)">
        <div class="bg-light d-flex m-auto">
            <div class="ml-2">
                <img src="/img/user-add.png" alt="" width="12" height="12">
            </div>
            <p class="my-auto mx-2">Ajouter</p>
        </div>
    </div>
</a>
@elseif($amis->amisDemande == false && $amis->amisActive == false)
<a class="text-decoration-none text-dark" href="{{ route('profil.amisInvit', $user->id)}}" role="button"
    aria-pressed="true">
    <div class="border border-dark"
        style="position: absolute;   top: 84%;   left: 90%;  transform: translate(-50%,-50%)">
        <div class="bg-light d-flex m-auto">
            <div class="ml-2">
                <img src="/img/user-invit.png" alt="" width="12" height="12">
            </div>
            <p class="my-auto mx-2">Invitation envoyée</p>
        </div>
    </div>
</a>
@else
<a class="text-decoration-none text-dark" href="{{ route('profil.amisDelete', $user->id)}}"
    role="button" aria-pressed="true">
    <div class="border border-dark"
        style="position: absolute;   top: 84%;   left: 90%;  transform: translate(-50%,-50%)">
        <div class="bg-light d-flex m-auto">
            <div class="ml-2">
                <img src="/img/" alt="" width="12" height="12">
            </div>
            <p class="my-auto mx-2">Retier des amis</p>
        </div>
    </div>
</a>
@endif
@endif
```

-   Code de l'application crush pour m'aider, merci de ne pas copier cela

```php
<ul class="card-body">
    @foreach ($user->amis as $amis)
    <li>{{ $amis->id }} - {{ $tag->name }} - Pivot Active = {{ $amis->pivot->active }}
        @if($amis->pivot->active) ✅ @else ❌ @endif > Created at
        {{ $amis->pivot->created_at->diffForHumans() }}
    </li>
      <li>{{ $amis->id }} - {{ $tag->name }} - Pivot Active = {{ $amis->pivot->active }}
        @if($amis->pivot->tagActive) ✅ @else ❌ @endif > Created at
        {{ $amis->pivot->created_at->diffForHumans() }}
    </li>
    @endforeach
</ul>
```
