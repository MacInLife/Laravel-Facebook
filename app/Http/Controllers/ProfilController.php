<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;

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
        //$u = $user->where('avatar', Auth::user()->avatar);
        //$u->update(['avatar'=> $path]);

    return redirect::back()->withOk("L'avatar a été modifié.");
    }
}
