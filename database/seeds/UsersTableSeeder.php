<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Salvador',
                'surname' => 'López',
                'email' => 'salva.lopez.rubio@gmail.com',
                'password' => Hash::make('**********'),
            ],
            [
                'name' => 'Ainhoa',
                'surname' => 'López',
                'email' => 'ailoru2006@gmail.com',
                'password' => Hash::make('**********'),
            ]
        ];

        foreach ($users as $key => $user) {
            factory(User::class, 1)->create($user);
        }
    }
}
