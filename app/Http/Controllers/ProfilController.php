<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    //
    public function index($id, User $user)
    {
        $pseudo = Auth::user()->pseudo;
        if($pseudo == null){
        $user = $user->where('id', $id)->first();
        }else{
         $user = $user->where('pseudo', $pseudo)->first();
        }
        //Retourne la view des posts
        return view('/auth/profil', [ 'user' => $user ]);
    }
}
