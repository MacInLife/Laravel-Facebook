<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use App\Amis;
use App\Like;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post, User $user, Like $like)
    {
        //Post de tout le monde
        //SELECT * FROM `likes` WHERE `post_id` =23
        $likes = $like->where('post_id', $post->id)->get();

        //Post de la personne connecter
        $posts = $post
        ->whereIn('user_id', Auth::user()->amisActive()->pluck('amis_id'))
        ->orWhere('user_id', Auth::user()->id)
        ->with('user')
        ->orderBy('id', 'DESC')
        ->paginate(4);

        //Retourne la view des posts

        //Récupère tous les users
        $users = $user->orderBy('id', 'DESC')->get()
        ->except(Auth::user()->id)->except(Auth::user()->amisActive()->pluck('amis_id')->toArray());

        return view('home', ['posts' => $posts, 'users' => $users, 'likes' => $likes  ]);
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
        return redirect::back();
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

    public function like($id, Post $post)
    {
        $user_id = Auth::user()->id;
        $like_post = $post->where('id', $id)->first();

        $like = new Like;
        $like->user_id = $user_id;
        $like->post_id = $like_post->id;
       // dd($like, $like_post, $like_post->text);
        $like->save();
        
        return redirect()->back()->withOk("Vous aimez la publication « " . $like_post->text . " » de " . $like_post->user_id . ".");
    }

    public function unlike($id, Like $unLike, Post $post)
    {
        $user_id = Auth::user()->id;
        $post_id = $post->where('id', $id)->first();

        //where == request
        $unlike = $unLike
            ->where('user_id', $user_id)
            ->where('post_id', $post_id->id)
            ->first();
        //dd($unlike);
        $unlike->delete();

        return redirect()->back()->withOk("Vous n'aimez plus le post : " . $post_id->text . " » de " . $post_id->user_id . ".");
    }
}
