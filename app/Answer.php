<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Answer extends Model
{
    protected $fillable = [
        'content',
        'correct'
    ];

    public function card() {
        return $this->belongsTo('App\Card');
    }
}
