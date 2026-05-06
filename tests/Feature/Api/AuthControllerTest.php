<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(){
        $response = $this->postJson('/api/register', [
            'name' => 'ahmad',
            'email' => 'ahmad@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => 'ahmad@gmail.com']);
    }

    public function test_registeration_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => '',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors( ['name', 'email', 'password']);
    }

    public function test_user_can_login()
    {

        User::factory()->create([
            'email' => 'ahmad@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'ahmad@gmail.com',
            'password' => '123456789',
        ]);

        $response->assertStatus(200);

    }

    public function test_login_fails_with_invalid_data()
    {

        $response = $this->postJson('/api/login', [
            'email' => 'notemail',
            'password' => '',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['email', 'password']);

    }
}
