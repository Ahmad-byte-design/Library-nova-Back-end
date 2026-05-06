<?php

namespace Tests\Feature\Api;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    // We'll create a user and a book once for the whole test class (or per test)
    // But for simplicity, create them inside each test.
    public function test_review_can_add()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $book = Book::factory()->create();
        $response = $this->postJson('/api/reviews', [
            'comments' => 'this book is good',
            'rating' => 4,
            'book_id' => $book->id,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('reviews', ['comments' => 'this book is good']);

    }

    public function test_adding_review_fails_invalid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $book = Book::factory()->create();

        $response = $this->postJson('/api/reviews', [
            'comments' => "hoal",
            'rating' => 10,
            'book_id' => $book->id,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([ 'rating']);
    }

    public function test_review_can_update()
    {
        // Create a user and a book first
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $response = $this->putJson("/api/reviews/{$review->id}", [
            'comments' => 'updated comment',
            'rating' => 5,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'comments' => 'updated comment',
        ]);
    }

    public function test_review_can_find()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $response = $this->getJson("/api/books/{$book->id}/reviews");
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $review->id]);


    }

    public function test_review_can_delete()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $response = $this->deleteJson("/api/reviews/{$review->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }
}
