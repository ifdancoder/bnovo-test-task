<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GuestController;
use App\Http\Controllers\CountryController;

Route::controller(GuestController::class)->group(function () {
    Route::get('/guests', 'index');
    Route::post('/guests', 'store');
    Route::get('/guests/{id}', 'show');
    Route::put('/guests/{id}', 'update');
    Route::delete('/guests/{id}', 'destroy');
});

Route::controller(CountryController::class)->group(function () {
    Route::get('/countries', 'index');
    Route::get('/countries/{id}', 'show');
});