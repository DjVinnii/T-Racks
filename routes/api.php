<?php

use App\Http\Controllers\Api\V1\LocationsController;
use App\Http\Controllers\Api\V1\RacksController;
use App\Http\Controllers\Api\V1\RowsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// TODO protect api routes

Route::group([
   'prefix' => 'v1',
], function () {

    Route::apiResources([
        'locations' => LocationsController::class,
        'rows' => RowsController::class,
        'racks' => RacksController::class,
    ]);
});

