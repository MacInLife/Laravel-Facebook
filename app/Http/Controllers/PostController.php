<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post, User $user)
    {
        //Post de tout le monde
        //$posts = $post->orderBy('id', 'DESC')->where('user_id', Auth::user()->id)->paginate(4);

        //Post de la personne connecter
        $posts = $post
        //->whereIn('user_id', Auth::user()->following()->pluck('follower_id'))
        ->orWhere('user_id', Auth::user()->id)
        ->with('user')
        ->orderBy('id', 'DESC')
        ->paginate(4);


        //Retourne la view des posts

        //Récupère tous les users
        $users = $user->orderBy('id', 'DESC')->get();

        return view('home', ['posts' => $posts, 'users' => $users ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post, Request $request)
    {
        //Validation
        $validate = $request->validate([
            'text' => 'required',
        ]);
        //Création
        $post = new Post;
        $post->text = $request->text;
        $post->user_id = $request->user_id;

        //Sauvegarde du post tweet
        $post->save();

        //Redirection
        return redirect('/home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Post $post)
    {
        //Trouve le post de l'utilisateur concerné
        $p = $post->find($id);
        //Si t'es authentifier alors il supprime
       if (Auth::check()) {
        $p->delete($id);

        //
        return redirect::back()->withOk("Le post " . $p->text . " a été supprimé.");
        }
    }
}
