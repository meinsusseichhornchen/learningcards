<?php

use App\Answer;
use App\Card;
use App\Cards\GuessByImage;
use App\Collection;
use App\Image;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;

class GuessByImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cards = [
            [
                'collection' => Collection::where('name', 'Filósofos Contemporáneos')->first()->id,
                'answers' => ['Gilles Deleuze (1925 — 1995)'],
                'images' => ['img_1.jpg'],
            ]
        ];

        foreach ($cards as $key => $card) {
            $newCard = GuessByImage::create();

            $newCard->card()->save(factory(Card::class, 1)->create([
                'collection_id' => $card['collection'],
                'cardable_id' => $newCard->id,
                'cardable_type' => 'App\Cards\GuessByImage'
            ])->first());

            $this->answers($card['answers'], $newCard->card);
            $this->images($card['images'], $newCard->card);
        }
    }

    protected function images(array $images, Card $card) {
        $card->deleteCardAssets();

        foreach ($images as $image) {
            Image::create([
                'url' => $card->saveCardAsset(new File(storage_path($card::ASSETS_SEED_FOLDER.$image))),
                'card_id' => $card->id,
            ]);
        }
    }

    protected function answers(array $answers, Card $card) {
        foreach ($answers as $answer) {
            Answer::create([
                'content' => $answer,
                'card_id' => $card->id,
            ]);
        }
    }
}
