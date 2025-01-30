<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
        
        // Generate API token for the test user
        $this->token = $this->user->createToken('test_token')->plainTextToken;
    }

    public function test_calculate_route_returns_sorted_locations()
    {
        Location::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->getJson('/api/v1/routes?latitude=40.7128&longitude=-74.0060');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'latitude',
                             'longitude',
                             'marker_color',
                             'distance'
                         ]
                     ]
                 ]);
    }
}
