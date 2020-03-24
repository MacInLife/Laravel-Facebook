<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Post;

class ProfilController extends Controller
{
    //
    public function index($slug, User $user, Post $post)
    {
        $u = $user->wherePseudo($slug)->first();

        if (!$u) {
            $u = $user->whereId($slug)->first();
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

    return redirect::back()->withOk("L'avatar a été modifié.");
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
        } 

    return redirect::back()->withOk("La photo de courverture a été modifié.");
    }
}
