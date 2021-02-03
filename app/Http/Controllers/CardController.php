<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Card;
use App\Http\Requests\StoreCard;
use App\Http\Requests\Cards\StoreGuessByImageCard;
use App\Http\Resources\CardResource;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Resources\CardCollection;
use Illuminate\Support\Facades\URL;

class CardController extends Controller
{
    public function edit(Card $card) {
        return view('cards/edit', [
            'card' => new CardResource($card),
            'links' => [
                'previous_page' => URL::previous()
            ]
        ]);
    }

    public function create(Collection $collection) {
        return view('cards/create', [
            'collection' => $collection
        ]);
    }

    public function update(StoreCard $request, Card $card) {

        $cardControllerClass = str_replace(
                                    class_basename(get_class($this)),
                                    'Cards\\'.class_basename($card->cardable_type).'Controller',
                                    get_class($this)
                                );

        $cardTypeStore = 'App\\Http\\Requests\\Cards\\Store'.class_basename($card->cardable_type).'Card';

        app($cardControllerClass)->update(new $cardTypeStore($request->all()), $card);
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

        if ($request->file('image')) {
            foreach ($request->file('image') as $image) {
                $card->images()->create([
                    'url' => $card->saveCardAsset(new File($image)),
                    'card_id' => $card->id,
                ]);
            }
        }

        return redirect()->route('show_collection', [$collection]);
    }

    protected function getNamespace() {
        return get_class($this);
    }
}
