<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Inertia\Inertia;
use Illuminate\Http\Request;

class LocationPageController
{
    public function index(Request $request)
    {
        return Inertia::render('Locations/Index');
    }

    public function show(Location $location)
    {
        return Inertia::render('Locations/Show', [
            'location' => $location->id,
        ]);
    }
}
