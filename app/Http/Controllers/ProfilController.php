<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Post;
use App\Amis;
use App\Like;

class ProfilController extends Controller
{
    //
    public function index($slug, User $user, Post $post, Like $like)
    {
        $u = $user->wherePseudo($slug)->first();

        if (!$u) {
            $u = $user->whereId($slug)->first();
          
        // dd($u->amisActive());
            if (!$u) {
                return redirect('/', 302);
            }
           
        }
        
        $posts = $post->orderBy('id', 'DESC')->get();

   

        //Retourne la view des posts
        return view('/auth/profil', [ 'user' => $u , 'posts' => $posts]);
    }

    public function updateAvatar(User $user)
    {
        $request = app('request');
        $path = null;
        //dd($request->file('avatar'));
        // Logic for user upload of avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = '/uploads/avatars/' . $filename;
            Image::make($avatar)->resize(200, 200)->save(public_path($path));
            //$user = $user->find($id);
            // $id = Auth::id();
            $user = Auth::user();
            $user->avatar = $path;
            $user->save();
        } 

    return redirect::back()->withOk("Votre avatar a été modifié.");
    }

    public function updateCover(User $user)
    {
        $request = app('request');
        $path = null;
        // Logic for user upload of avatar
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $filename = time() . '.' . $cover->getClientOriginalExtension();
            $path = '/uploads/covers/' . $filename;
            Image::make($cover)->resize(930, 315)->save(public_path($path));
            $user = Auth::user();
            $user->cover = $path;
            $user->save();
           // dd($cover);
        } 

    return redirect::back()->withOk("Votre photo de courverture a été modifié.");
    }


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

    public function amis_invit($id, Amis $amis, User $user)
    {
        $user_id = Auth::user()->id;
        $amis_invit = $user->where('id', $id)->first();
       
        //where == request
        $amis = new Amis;
        $amis->user_id = $user_id;  
        $amis->amis_id = $amis_invit->id; 
        $amis->active = 1;
       //dd($amis);
        $amis->save();

        $amisAccept = $amis
        ->where('amis_id', $user_id)
        ->where('user_id', $amis_invit->id)
        ->first();
        $amisAccept->active = 1;
        $amisAccept->update();

        return redirect()->back()->withOk("Vous avez accepter la demande d'amis de " . $amis_invit->name ." ". $amis_invit->firstname . " !");
    }

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

        $amisLiaison = $amis
        ->where('user_id', $amis_delete->id)
        ->where('amis_id', $user_id)
        ->first();
       // dd($amis);
        $amisLiaison->delete();

        return redirect()->back()->withOk("Vous n'êtes plus amis avec " . $amis_delete->name ." ". $amis_delete->firstname . " !");
    }
}
