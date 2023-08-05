<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_authenticate()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/users/authenticate', [
            'email' => $user->email,
            'password' => 'piljur123',
        ]);

        $response->assertStatus(200);
    }

    public function test_invalid_credential()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/users/authenticate', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401);
    }

    public function test_the_given_data_was_invalid()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/users/authenticate', [
            'email' => '',
            'password' => '.,/',
        ]);

        $response->assertStatus(422);
    }
}
