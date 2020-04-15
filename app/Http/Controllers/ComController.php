<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ComController extends Controller
{
    //
    public function createCom(Post $post, Request $request)
    {
        //Validation
        $validate = $request->validate([
            'text' => 'required',
        ]);
        //Création
        $post = new Post;
        $post->text = $request->text;
        $post->user_id = Auth::user()->id;
        $post->parent_id = $request->parent_id;

        //Sauvegarde du post tweet
        $post->save();

        //Redirection
        return redirect::back();
    }

    public function destroyCom($id, Post $post)
    {
        //Trouve le post de l'utilisateur concerné
        $p = $post->find($id);
        //Si t'es authentifier alors il supprime
       if (Auth::check()) {
        $p->delete($id);

        //
        return redirect::back()->withOk("La publication «" . $p->text . "» a été supprimé.");
        }
    }
}
