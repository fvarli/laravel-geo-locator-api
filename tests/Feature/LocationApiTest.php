<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationApiTest extends TestCase
{

    use RefreshDatabase;

    public function test_index_returns_all_locations()
    {
        $locations = Location::factory()->count(10)->create();
    
        $response = $this->getJson('/api/v1/locations');
    
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'latitude',
                             'longitude',
                             'marker_color'
                         ]
                     ]
                 ]);
    }

    public function test_store_creates_a_new_location()
    {
        $locationData = [
            'name' => 'Test Location',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'marker_color' => '#ffffff'
        ];

        $response = $this->postJson('/api/v1/locations', $locationData);

        $response->assertStatus(201)
                 ->assertJson(['data' => $locationData]);
    }

    public function test_show_returns_a_specific_location()
    {
        $location = Location::factory()->create();

        $response = $this->getJson("/api/v1/locations/{$location->id}");

        $response->assertStatus(200)
                 ->assertJson(['data' => [
                     'id' => $location->id,
                     'name' => $location->name,
                     'latitude' => $location->latitude,
                     'longitude' => $location->longitude,
                     'marker_color' => $location->marker_color
                 ]]);
    }

    public function test_update_modifies_an_existing_location()
    {
        $location = Location::factory()->create();
        $updatedData = [
            'name' => 'Updated Location',
            'latitude' => 34.0522,
            'longitude' => -118.2437,
            'marker_color' => '#000000'
        ];

        $response = $this->putJson("/api/v1/locations/{$location->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['data' => $updatedData]);
    }

    public function test_destroy_deletes_a_location()
    {
        $location = Location::factory()->create();

        $response = $this->deleteJson("/api/v1/locations/{$location->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Location deleted successfully']);

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }
}
