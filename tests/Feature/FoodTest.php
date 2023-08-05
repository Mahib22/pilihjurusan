<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FoodTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_foods()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        Food::create([
            'name' => 'Burger',
            'price' => 25000,
            'description' => 'Delicious burger'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/foods');

        $response->assertStatus(200);
    }

    public function test_it_can_create_a_food()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $foodData = [
            'name' => 'Burger',
            'price' => 25000,
            'description' => 'Delicious burger'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/foods', $foodData);

        $response->assertStatus(200);
    }

    public function test_it_can_show_a_food()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $food = Food::create([
            'name' => 'Burger',
            'price' => 25000,
            'description' => 'Delicious burger'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("/api/foods/{$food->id}");

        $response->assertStatus(200);
    }

    public function test_it_can_update_a_food()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $food = Food::create([
            'name' => 'Burger',
            'price' => 25000,
            'description' => 'Delicious burger'
        ]);

        $newData = [
            'name' => 'Delicious Pizza',
            'price' => 55000,
            'description' => 'A mouth-watering pizza',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/foods/{$food->id}", $newData);

        $response->assertStatus(200);
    }

    public function test_it_can_delete_a_food()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $food = Food::create([
            'name' => 'Burger',
            'price' => 25000,
            'description' => 'Delicious burger'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete("/api/foods/{$food->id}");

        $response->assertStatus(204);
    }
}
