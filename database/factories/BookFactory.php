<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "ISBN"=>fake()->numerify('978#########'),
            "title"=>fake()->sentence(3),
            "description"=>fake()->sentence(),
            "published_date"=>fake()->date(),
            // "book_uploads" =>fake()->imageUrl(640, 480, 'animals', true),
            "book_upload"=>fake()->url(),
            "image"=>fake()->url(),
            "author_id"=> Author::factory(),
            "category_id"=> Category::factory()
        ];
    }
}
