<?php

namespace App\Cards;

use App\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GuessByImage extends Model
{
    public $timestamps = false;

    public function card() {
        return $this->morphOne('App\Card', 'cardable');
    }

    public static function create(array $attributes = []) {
        return static::query()->create($attributes);
    }
}
