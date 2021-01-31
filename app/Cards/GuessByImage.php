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

    public function updateAnswers($answers) {
        $length = count($this->card->answers) > count($answers)
                    ? count($this->card->answers)
                    : count($answers);

        for ($i = 0; $i < $length; $i++) {
            if (isset($answers[$i])) {

                if (isset($this->card->answers[$i])) {
                    $this->card->answers[$i]->update([
                        'content' => $answers[$i],
                    ]);

                    continue;
                }

                $this->card->answers()->create([
                    'content' => $answers[$i],
                ]);

                continue;
            }

            $this->card->answers[$i]->delete();
        }
    }
}
