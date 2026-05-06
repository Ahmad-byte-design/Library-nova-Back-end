<?php

namespace Tests\Feature\Api;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{

use RefreshDatabase;


    public function test_author_can_get_all()
    {
        Author::factory(3)->create();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(200);
    }

    public function test_author_can_add()
    {
        $response = $this->postJson('/api/authors', [
            'name' => 'ahmad',
            'date_of_birth' => '2002-10-10',
            'information' => 'is the best author in the world',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('authors',["name"=>"ahmad"]);
    }

    public function test_adding_author_fails_invalid_data()
    {
        $response = $this->postJson('/api/authors', [
            'name' => '',
            'date_of_birth' => 'nothing',
            'information' => 'is  in the world',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors( ['name', 'date_of_birth']);

    }



        public function test_author_can_update()
    {
        $author = Author::factory()->create();

        $response = $this->putJson("/api/authors/{$author->id}", [
            'name' => 'stille ahmad',
            'date_of_birth' => '2002-10-10',
            'information' => 'is the best author in the world',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas("authors",["id"=>$author->id , "name"=>"stille ahmad"]);
    }

    public function test_author_can_find()
    {
        $author = Author::factory()->create();
        $response = $this->getJson("/api/authors/{$author->id}");

        $response->assertStatus(200);

        $response->assertJson(["id"=>$author->id ]);
    }



    public function test_author_can_delete()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing("authors",["id"=>$author->id ]);

    }





}
