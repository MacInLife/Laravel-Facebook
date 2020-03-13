<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    //
    public function index($slug, User $user)
    {
        $u = $user->wherePseudo($slug)->first();

        if (!$u) {
            $u = $user->whereId($slug)->first();
            if (!$u) {
                return redirect('/', 302);
            }
        }
       

        //Retourne la view des posts
        return view('/auth/profil', [ 'user' => $u ]);
    }
}
