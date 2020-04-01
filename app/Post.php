<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Gestion de la liaison entre les 2 tables
    public function user(){
        return $this->belongsTo(\App\User::class);
    }


    public function likes(){
        //Relation à plusieurs n à n //table 'like_unlike', post_id > user_id
        return $this->belongsToMany(Post::class, 'likes','user_id', 'post_id')->withPivot('created_at');
        }
}
