<?php

use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HardwareTypeController;
use App\Http\Controllers\Ipv4NetworkController;
use App\Http\Controllers\Ipv6NetworkController;
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
    Route::get('/hardware_type/datatable', [App\Http\Controllers\HardwareTypeController::class, 'datatable'])->name('hardware_type.datatable');
    Route::get('/ipv4_network/datatable', [App\Http\Controllers\Ipv4NetworkController::class, 'datatable'])->name('ipv4_network.datatable');
    Route::get('/ipv6_network/datatable', [App\Http\Controllers\Ipv6NetworkController::class, 'datatable'])->name('ipv6_network.datatable');
    Route::get('/rack/datatable', [App\Http\Controllers\RackController::class, 'datatable'])->name('rack.datatable');

    Route::resources([
        'hardware' => HardwareController::class,
        'hardware_type' => HardwareTypeController::class,
        'ipv4_network' => Ipv4NetworkController::class,
        'ipv6_network' => Ipv6NetworkController::class,
        'rack' => RackController::class,
    ]);
});



