<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password',
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

    public function scores() {
        return $this->belongsToMany('App\Collection', 'scores', 'user', 'collection')
            ->withPivot('rights', 'wrongs', 'played_at', 'attached_at');
    }

    public function collections() {
        return $this->hasMany('App\Collection', 'author');
    }

    public function tags() {
        return $this->hasMany('App\Tag', 'author');
    }

    public static function last() {
        return self::orderBy('id', 'DESC')->first();
    }

    public static function first() {
        return self::orderBy('id', 'ASC')->first();
    }
}
