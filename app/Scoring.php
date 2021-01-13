<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Scoring extends Pivot
{
    public $casts = [
        'played_at' => 'datetime:Y-m-d',
        'attached_at' => 'datetime:Y-m-d',
    ];
}
