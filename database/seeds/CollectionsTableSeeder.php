<?php

use App\Collection;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CollectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collections = [
            [
                'name' => 'Filósofos Contemporáneos',
                'description' => 'Filósofos existentes en la actualiddad.',
                'author' => User::inRandomOrder()->first()->id,
                'tags' => [1],
                'players' => User::pluck('id')->toArray(),
            ],
            [
                'name' => 'Filósofos Presocráticos',
                'author' => User::inRandomOrder()->first()->id,
                'tags' => [1],
                'players' => User::pluck('id')->toArray(),
            ],
            [
                'name' => 'Filósofos Postsocráticos',
                'description' => 'Filósofos del periodo posterior a la irrupción de Socrates en la Antigua Grecia (Aristóteles).',
                'author' => User::inRandomOrder()->first()->id,
                'tags' => [1],
                'players' => User::pluck('id')->toArray(),
            ]
        ];

        foreach ($collections as $key => $collection) {
            $newCollection = factory(Collection::class, 1)->create([
                'name' => $collection['name'],
                'description' => isset($collection['description']) ? $collection['description'] : '',
                'author' => $collection['author'],
            ])->first();

            if ($collection['tags'] != null) {
                $newCollection->tags()->sync($collection['tags']);
            }

            if ($collection['players'] !== null) {
                $newCollection->players()->sync($collection['players']);
            }
        }
    }
}
