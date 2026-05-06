<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

       public function test_category_can_get_all()
    {
        Category::factory(3)->create();
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);
    }

    public function test_category_can_add()
    {
        $response = $this->postJson('/api/categories', ['name' => 'fantasy']);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', ['name' => 'fantasy']);
    }

    public function test_adding_category_fails_invalid_data()
    {
        $response = $this->postJson('/api/categories', ['name' => 3434]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_category_can_update()
    {
        $category = Category::factory()->create();
        $response = $this->putJson("/api/categories/{$category->id}", ['name' => 'new fantasy']);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'new fantasy']);
    }

    public function test_category_can_find()
    {
        $category = Category::factory()->create();
        $response = $this->getJson("/api/categories/{$category->id}");
        $response->assertStatus(200);
        $response->assertJson(['id' => $category->id]);
    }

    public function test_category_can_delete()
    {
        $category = Category::factory()->create();
        $response = $this->deleteJson("/api/categories/{$category->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
