<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Card;
use App\Http\Requests\StoreCard;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Resources\CardCollection;

class CardController extends Controller
{
    public function edit(Card $card) {
        return view('cards/edit', [
            'card' => new CardCollection([$card])
        ]);
    }

    public function create(Collection $collection) {
        return view('cards/create', [
            'collection' => $collection
        ]);
    }

    public function store(StoreCard $request, Collection $collection) {
        $cardClass = Card::getNamespace().$request->cardable_type;

        $card = $collection->cards()->create([
            'cardable_type' => Card::getNamespace().$request->cardable_type,
            'cardable_id' =>  $cardClass::create([])->id,
        ]);

        $answers = [];

        foreach ($request->answer as $answer) {
            if (!is_null($answer)) {
                $answers[] = $card->answers()->create([
                    'content' => $answer
                ]);

                continue;
            }

            $card->answers()->create();
        }

        foreach ($request->file('image') as $image) {
            $image = $card->images()->create([
                'url' => $card->saveCardAsset(new File($image)),
                'card_id' => $card->id,
            ]);
        }


    }
}
