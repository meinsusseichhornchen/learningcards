<?php

namespace App\Http\Controllers\Cards;

use App\Answer;
use App\Card;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cards\StoreGuessByImageCard;
use App\Image;
use Illuminate\Http\Request;

class GuessByImageController extends Controller
{
    public function update(StoreGuessByImageCard $request, Card $card) {
        $card->cardable->updateAnswers($request->answer);

        Image::where('card_id', $card->id)->get()->each(function($image) {
            $image->delete();
        });

        foreach ($request->images as $image) {
            $card->images()->create([
                'url' => $card->saveCardAsset($image),
                'card_id' => $card->id
            ]);
        }
    }
}
