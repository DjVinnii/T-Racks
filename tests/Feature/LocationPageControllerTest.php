<?php

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

it('renders the locations index page via Inertia', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->get('/locations');

    $response->assertSuccessful();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Locations/Index'));
});

it('redirects unauthenticated users from the locations index to login', function () {
    $response = $this->get('/locations');

    $response->assertRedirect(route('login'));
});

it('renders the show page and passes the location id as a prop', function () {
    $this->actingAs(User::factory()->create());

    $location = Location::factory()->create();

    $response = $this->get("/locations/{$location->id}");

    $response->assertSuccessful();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Locations/Show')->where('location', $location->id));

});

it('redirects unauthenticated users from the locations show page to login', function () {
    $location = Location::factory()->create();

    $response = $this->get("/locations/{$location->id}");

    $response->assertRedirect(route('login'));
});
