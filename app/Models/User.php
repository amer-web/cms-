<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Nicolaslopezj\Searchable\SearchableTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use LaratrustUserTrait, SearchableTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'users.name' => 10 ,
            'users.username' => 10 ,
            'users.email' => 10 ,
            'users.mobile' => 10 ,
        ]
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
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /* start accessor */
    public function getStatusAttribute($val)
    {
        return  ($val == 1)? 'Active' : 'InActive';
    }
    public function getUserImageAttribute($val)
    {
        return ($val != null)? $val : 'assest/users/user.png';
    }
    /*
        end accessor
    */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function allComments()
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }
    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }
}
