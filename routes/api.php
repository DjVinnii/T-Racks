<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RackController;
use App\Http\Controllers\Api\StatsController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('racks', RackController::class);
    Route::get('stats', [StatsController::class, 'index']);
});
