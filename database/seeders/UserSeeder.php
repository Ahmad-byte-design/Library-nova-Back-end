<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory()->count(20)->create();

        $bookIds = Book::pluck('id');

        foreach ($users as $user ) {

            $user->saves()->attach(
                $bookIds->random(rand(1,5))
            );

            $user->favorites()->attach(
                $bookIds->random(rand(1,5))
            );

        }


    }
}
