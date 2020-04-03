<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Gestion de la liaison entre les 2 tables
    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function postLike(){
    return $this->hasMany(Like::class,'post_id');
    }
}
