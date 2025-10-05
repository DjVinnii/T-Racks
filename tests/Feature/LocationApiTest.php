<?php

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists locations', function () {
    Location::factory()->count(2)->create();
    $response = $this->getJson('/api/locations');

    $response->assertSuccessful();
    $payload = $response->json();

    // Paginated responses expose a 'data' key with items
    expect(array_key_exists('data', $payload))->toBeTrue();
    expect(count($payload['data']))->toBe(2);
});

it('filters locations by name', function () {
    Location::factory()->create(['name' => 'Alpha City']);
    Location::factory()->create(['name' => 'Beta Town']);

    $response = $this->getJson('/api/locations?name=Alpha');

    $response->assertSuccessful();
    $payload = $response->json();

    expect(count($payload['data']))->toBe(1);
    $response->assertJsonFragment(['name' => 'Alpha City']);
});

it('creates a location', function () {
    $payload = ['name' => 'New City'];

    $response = $this->postJson('/api/locations', $payload);

    $response->assertStatus(201);
    $response->assertJsonFragment(['name' => 'New City']);
    expect(Location::where('name', 'New City')->exists())->toBeTrue();
});

it('shows a location', function () {
    $location = Location::factory()->create();

    $response = $this->getJson('/api/locations/'.$location->id);

    $response->assertSuccessful();
    $response->assertJsonFragment(['name' => $location->name]);
});

it('updates a location', function () {
    $location = Location::factory()->create(['name' => 'Old']);

    $response = $this->putJson('/api/locations/'.$location->id, ['name' => 'Updated']);

    $response->assertSuccessful();
    $response->assertJsonFragment(['name' => 'Updated']);
    expect($location->fresh()->name)->toBe('Updated');
});

it('deletes a location', function () {
    $location = Location::factory()->create();

    $response = $this->deleteJson('/api/locations/'.$location->id);

    $response->assertStatus(204);
    expect(Location::where('id', $location->id)->exists())->toBeFalse();
});

it('store validation fails when name is missing', function () {
    $response = $this->postJson('/api/locations', []);

    $response->assertStatus(422);
    $response->assertJson(['message' => 'The name field is required.']);
    $response->assertJsonValidationErrors('name');
});

it('store validation fails when name is too long', function () {
    $payload = ['name' => str_repeat('a', 256)];

    $response = $this->postJson('/api/locations', $payload);

    $response->assertStatus(422);
    $response->assertJson(['message' => 'The name field must not be greater than 255 characters.']);
    $response->assertJsonValidationErrors('name');
});

it('update validation fails when name is empty', function () {
    $location = Location::factory()->create();

    $response = $this->putJson('/api/locations/'.$location->id, ['name' => '']);

    $response->assertStatus(422);
    $response->assertJson(['message' => 'The name field is required.']);
    $response->assertJsonValidationErrors('name');
});

it('update validation fails when name is too long', function () {
    $location = Location::factory()->create();

    $response = $this->putJson('/api/locations/'.$location->id, ['name' => str_repeat('a', 256)]);

    $response->assertStatus(422);
    $response->assertJson(['message' => 'The name field must not be greater than 255 characters.']);
    $response->assertJsonValidationErrors('name');
});
