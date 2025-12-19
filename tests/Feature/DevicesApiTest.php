<?php

use App\Models\Device;
use App\Models\Rack;

it('lists devices', function () {
    $rack = Rack::factory()->create();
    Device::factory()->count(2)->for($rack)->create();

    $response = $this->getJson('/api/devices');

    $response->assertSuccessful();
    $payload = $response->json();

    expect(array_key_exists('data', $payload))->toBeTrue();
    expect(count($payload['data']))->toBe(2);
});

it('creates a device', function () {
    $rack = Rack::factory()->create();
    $payload = ['name' => 'New Device', 'rack_id' => $rack->id];

    $response = $this->postJson('/api/devices', $payload);

    $response->assertStatus(201);
    $response->assertJsonFragment(['name' => 'New Device']);
    expect(Device::where('name', 'New Device')->exists())->toBeTrue();
});

it('shows a device', function () {
    $rack = Rack::factory()->create();
    $device = Device::factory()->for($rack)->create();

    $response = $this->getJson('/api/devices/'.$device->id);

    $response->assertSuccessful();
    $response->assertJsonFragment(['name' => $device->name]);
});

it('updates a device', function () {
    $rack = Rack::factory()->create();
    $device = Device::factory()->for($rack)->create();

    $response = $this->putJson("/api/devices/{$device->id}", [
        'name' => 'Updated Device',
        'rack_id' => null,
    ]);

    $response->assertOk();
    $response->assertJsonFragment(['name' => 'Updated Device']);
});

it('deletes a device', function () {
    $rack = Rack::factory()->create();
    $device = Device::factory()->create(['rack_id' => $rack->id]);

    $response = $this->deleteJson("/api/devices/{$device->id}");

    $response->assertStatus(204);
    expect(Device::where('id', $device->id)->exists())->toBeFalse();
});