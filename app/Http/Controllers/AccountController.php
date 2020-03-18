<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    //
    public function show()
    {
        return view('/auth/account', ['user' => Auth::user()]);
    }

    public function account()
    {
        return view('/auth/account', array('user' => Auth::user()));
    }

    public function update(User $user)
    {
    
    $request = app('request');
    $path = null;
    
        // Logic for user upload of avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = '/uploads/avatars/' . $filename;
            Image::make($avatar)->resize(100, 100)->save(public_path($path));
            //$user = $user->find($id);
            // $id = Auth::id();
            $user = Auth::user();
            $user->avatar = $path;
            $user->save();
        } else if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = '/uploads/avatars/' . $filename;
            Image::make($avatar)->resize(200, 200)->save(public_path($path));
            //$user = $user->find($id);
            // $id = Auth::id();
            $user = Auth::user();
            $user->avatar = $path;
            $user->name = $request->name;
            $user->firstname = $request->firstname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            $user = Auth::user();
            $user->name = $request->name;
            $user->firstname = $request->firstname;
            $user->pseudo = $request->pseudo;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
        }
    
    return redirect('/account')->withOk("L'utilisateur " . $user->firstname ." ". $user->name . " a été modifié.");
    }
    
    public function destroy($id, User $user)
    {
    $u = $user->find($id);
    //$posts = $post->where('user_id', Auth::user()->id);
    $u->delete($id);
    //$posts->delete($id);
    return redirect('/')->withOk("L'utilisateur ". $user->firstname ." ". $user->name . " a été supprimé.");
    //->withOk("L'utilisation'" . $u->name . " a été supprimé.");
    }

    public function destroyAvatar(User $user)
    {
      
    $u = $user->where('avatar', Auth::user()->avatar);
    $u->update(['avatar'=> '/img/avatar-vide.png']);

    return redirect('/account')->withOk("Votre avatar à bien été modifié");
    }


}
