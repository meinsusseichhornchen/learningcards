<?php

use App\Tag;
use App\User;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $tags = [
            [
                'name' => 'Filosofía',
                'author' => User::first(),
            ],
            [
                'name' => 'Libros',
                'author' => User::first(),
            ],
            [
                'name' => 'Geógrafos',
                'author' => User::first(),
            ]
        ];

        foreach ($tags as $key => $tag) {
            factory(Tag::class, 1)->create($tag);
        }
    }
}
