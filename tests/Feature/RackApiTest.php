<?php

use App\Models\Location;
use App\Models\Rack;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists racks', function () {
    $loc = Location::factory()->create();
    Rack::factory()->count(2)->create(['location_id' => $loc->id]);

    $response = $this->getJson('/api/racks');

    $response->assertSuccessful();
    $payload = $response->json();

    expect(array_key_exists('data', $payload))->toBeTrue();
    expect(count($payload['data']))->toBe(2);
});

it('filters racks by name and location', function () {
    $locA = Location::factory()->create();
    $locB = Location::factory()->create();

    Rack::factory()->create(['location_id' => $locA->id, 'name' => 'Alpha Rack']);
    Rack::factory()->create(['location_id' => $locB->id, 'name' => 'Beta Rack']);

    $response = $this->getJson('/api/racks?name=Alpha');
    $response->assertSuccessful();
    $payload = $response->json();
    expect(count($payload['data']))->toBe(1);

    $response = $this->getJson('/api/racks?location_id='.$locB->id);
    $payload = $response->json();
    expect(count($payload['data']))->toBe(1);
    $response->assertJsonFragment(['name' => 'Beta Rack']);
});

it('creates a rack', function () {
    $loc = Location::factory()->create();
    $payload = ['location_id' => $loc->id, 'name' => 'New Rack'];

    $response = $this->postJson('/api/racks', $payload);

    $response->assertStatus(201);
    $response->assertJsonFragment(['name' => 'New Rack']);
    expect(Rack::where('name', 'New Rack')->exists())->toBeTrue();
});

it('shows a rack', function () {
    $loc = Location::factory()->create();
    $rack = Rack::factory()->create(['location_id' => $loc->id]);

    $response = $this->getJson('/api/racks/'.$rack->id);

    $response->assertSuccessful();
    $response->assertJsonFragment(['name' => $rack->name]);
});

it('updates a rack', function () {
    $loc = Location::factory()->create();
    $rack = Rack::factory()->create(['location_id' => $loc->id, 'name' => 'Old Rack']);

    $response = $this->putJson('/api/racks/'.$rack->id, ['name' => 'Updated Rack']);

    $response->assertSuccessful();
    $response->assertJsonFragment(['name' => 'Updated Rack']);
    expect($rack->fresh()->name)->toBe('Updated Rack');
});

it('deletes a rack', function () {
    $loc = Location::factory()->create();
    $rack = Rack::factory()->create(['location_id' => $loc->id]);

    $response = $this->deleteJson('/api/racks/'.$rack->id);

    $response->assertStatus(204);
    expect(Rack::where('id', $rack->id)->exists())->toBeFalse();
});

it('store validation fails when required fields missing', function () {
    $response = $this->postJson('/api/racks', []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name']);
});

it('update validation fails when name is empty', function () {
    $loc = Location::factory()->create();
    $rack = Rack::factory()->create(['location_id' => $loc->id]);

    $response = $this->putJson('/api/racks/'.$rack->id, ['name' => '']);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name']);
});
