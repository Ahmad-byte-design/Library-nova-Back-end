<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "comments"=>fake()->sentence(),
            "rating" =>fake()->numberBetween(0,5),
            "user_id"=>User::inRandomOrder()->value("id"),
            "book_id"=>Book::inRandomOrder()->value("id")
        ];
    }
}
