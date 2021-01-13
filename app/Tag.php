<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'author'
    ];

    //
    public function collections() {
        return $this->belongsToMany('App\Collections', 'collection_tag');
    }
}
