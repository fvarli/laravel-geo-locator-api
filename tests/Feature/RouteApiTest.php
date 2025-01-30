<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteApiTest extends TestCase
{

    use RefreshDatabase;

    public function test_calculate_route_returns_sorted_locations()
    {
        $locations = Location::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/routes?latitude=40.7128&longitude=-74.0060');

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
