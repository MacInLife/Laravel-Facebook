<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Post;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'cover','firstname','name','pseudo', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatar() {
        if (!$this->avatar) {
                    return '/img/avatar-vide.png';
                }
                return $this->avatar;
    }
    public function getCover() {
        if (!$this->cover) {
                    return '/img/banner.jpeg';
                }
                return $this->cover;
    }

    public function amisAll(){
        //Relation à plusieurs n à n //table 'amis_dmd', user_id > amis_id
          //Many To Many - withPivot = recup booleen
          return $this->belongsToMany(\App\User::class, 'amis','user_id', 'amis_id')->withPivot('active')->withPivot('created_at');
    }

    public function amisActive()
    {
         //Relation à plusieurs n à n //table 'amis_dmd', user_id > amis_id
        return $this->belongsToMany(\App\User::class, 'amis','user_id', 'amis_id')
            ->withPivot('active')->withPivot('created_at')
            ->wherePivot('active', true);
    }

    public function amisNotActive()
    {
        return $this->belongsToMany(\App\User::class ,'amis','user_id', 'amis_id')
            ->withPivot('active')->withPivot('created_at')
            ->wherePivot('active', false);
    }

    public function amisWait()
    {
        return $this->belongsToMany(\App\User::class ,'amis','amis_id', 'user_id')
            ->withPivot('active')->withPivot('created_at')
            ->wherePivot('active', false);
    }

    public function isLike(Post $post){
    return $post->hasMany(Like::class,'post_id')->where('user_id', $this->id)->count();
    }

    public function posts() {
        return $this->hasMany(\App\Post::class, 'user_id');
    }
}
