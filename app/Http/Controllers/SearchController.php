<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public function index(User $user)
    {
        $user = User::all();

        $search = \Request::get('search');  

        $users = User::where('name','=','%'.$search.'%')
            ->orderBy('name')
            ->paginate(20);

        return view('search',compact('users'))->withuser($user);

    }
}
