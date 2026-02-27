<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShipsController;
use App\Http\Controllers\CrewController;
use App\Http\Controllers\PortsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ShipmentsController;


Route::get('/', function () {
    return view('home');
});

// Resource routes

Route::resource('Ships', App\Http\Controllers\ShipsController::class);
Route::resource('crew', CrewController::class);
Route::resource('ports', PortsController::class);
Route::resource('clients', ClientsController::class);
Route::resource('cargo', CargoController::class);
Route::resource('shipments', ShipmentsController::class);

