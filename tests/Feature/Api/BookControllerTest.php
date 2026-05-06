<?php

namespace Tests\Feature\Api;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_can_get_all()
    {


        Book::factory(10)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);

        $response->assertJsonCount(10, 'data');

    }

    public function test_book_can_add()
    {

        $author = Author::factory()->create();

        $category = Category::factory()->create();

        $response = $this->postJson('/api/books', [
            'ISBN' => '1111111111111',
            'title' => 'goodzilla',
            'description' => 'the bad moving',
            'published_date' => '2020-2-2',
            'category_id' => $category->id,
            'author_id' => $author->id,
            'book_upload' => 'https://google.com',
            'image' => 'https://google.com',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('books', ['title' => 'goodzilla']);
    }

    public function test_book_can_update()
    {
        $book = Book::factory()->create();
        $author = Author::factory()->create();

        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'updated goodzilla',
            'author_id' => $author->id,
        ]);

        $response->assertStatus(201);

        $this->assertDataBaseHas('books', ['id' => $book->id, 'title' => 'Updated goodzilla']);
    }

    public function test_book_can_find()
    {

        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200);
        $response->assertJson(['id' => $book->id]);
    }

    public function test_book_can_delete()
    {

        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
