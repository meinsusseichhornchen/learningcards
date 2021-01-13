<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Collection;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardCollection;
use App\Http\Resources\CollectionCollection;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Collection $collection, Request $request) {
        $cards = $collection->cards()->paginate(3);

        return new CardCollection($cards);
    }

    public function destroy(Card $card) {
        $collection = $card->collection;

        $card->delete();

        $cards = $collection->cards()->paginate(3);

        return new CardCollection($cards);
    }

    public function types(Request $request) {
        return Card::types();
    }
}
