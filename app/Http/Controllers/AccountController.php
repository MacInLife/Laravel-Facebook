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

   


}
