<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url'
    ];

    protected static function boot() :void
    {
        parent::boot();

        static::deleting(function($image) {
            $image->card->deleteCardAssets();
        });
    }

    public function card() {
        return $this->belongsTo('App\Card');
    }
}
