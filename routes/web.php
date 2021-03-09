<?php

use App\Http\Controllers\HardwareController;
use App\Http\Controllers\RackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::get('/hardware/datatable', [App\Http\Controllers\HardwareController::class, 'datatable'])->name('hardware.datatable');
    Route::get('/rack/datatable', [App\Http\Controllers\RackController::class, 'datatable'])->name('rack.datatable');

    Route::resources([
        'hardware' => HardwareController::class,
        'rack' => RackController::class,
    ]);
});



