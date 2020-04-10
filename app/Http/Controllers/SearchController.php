<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public function index(User $user)
    {
        $search = \Request::get('search');  

        $users = User::where('name','LIKE','%'.$search.'%')
        ->orWhere('firstname','LIKE','%'.$search.'%')
        ->orWhere('pseudo','LIKE','%'.$search.'%')
            ->orderBy('name')
            ->paginate(10);
    //dd($users);
    //dd($search);

        return view('search',compact('users'))->withuser($user);
    }
}
