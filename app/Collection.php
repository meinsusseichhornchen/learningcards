<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    //
    protected $fillable = [
        'name', 'description'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'author');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }

    public function players() {
        return $this->belongsToMany('App\User', 'scores', 'collection', 'user')
            ->using('App\Scoring')
            ->withPivot('rights', 'wrongs', 'played_at', 'attached_at');
    }

    public function cards() {
        return $this->hasMany('App\Card');
    }

    public static function first() {
        return self::orderBy('id', 'ASC')->first();
    }

}
