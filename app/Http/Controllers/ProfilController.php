<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfilController extends Controller
{
    //
    public function index($id, User $user)
    {
        //
        //$posts = $post->orderBy('id', 'DESC')->get();
        //$post->user_id = $request->user_id;
        //SELECT * FROM posts WHERE(user_id = 14)
        //$post->user_id = 14;
        //$user = $user->where('pseudo', $pseudo)->first();
        $user = $user->where('id', $id)->first();
        //$myPosts = $post->where('user_id', $user->id)->get();
        
        //Retourne la view des posts
        return view('/auth/profil', [ 'user' => $user ]);
    }
}
