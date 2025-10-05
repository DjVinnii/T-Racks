<?php

use App\Models\Location;
use App\Models\Rack;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns totals and a 30 day series for locations and racks', function () {
    // Create locations spread across the last 5 days and some older
    Location::factory()->count(3)->create(["created_at" => now()->subDays(0)]);
    Location::factory()->count(2)->create(["created_at" => now()->subDays(1)]);
    Location::factory()->count(1)->create(["created_at" => now()->subDays(5)]);

    // Create racks spread across the last 3 days
    Rack::factory()->count(4)->create(["created_at" => now()->subDays(0)]);
    Rack::factory()->count(2)->create(["created_at" => now()->subDays(2)]);

    $response = $this->getJson('/api/stats');

    $response->assertSuccessful();

    $json = $response->json();

    // Totals
    expect($json)->toHaveKey('totals');
    expect($json['totals']['locations'])->toBe(Location::count());
    expect($json['totals']['racks'])->toBe(Rack::count());

    // Series shape
    expect($json)->toHaveKey('series');
    $series = $json['series'];

    expect($series)->toHaveKey('labels');
    expect($series)->toHaveKey('locations');
    expect($series)->toHaveKey('racks');

    // 30 days
    expect(count($series['labels']))->toBe(30);
    expect(count($series['locations']))->toBe(30);
    expect(count($series['racks']))->toBe(30);

    // Ensure recent counts are reflected (non-zero at day 0)
    $lastIndex = count($series['labels']) - 1;
    expect($series['locations'][$lastIndex])->toBeGreaterThanOrEqual(3);
    expect($series['racks'][$lastIndex])->toBeGreaterThanOrEqual(4);
});
