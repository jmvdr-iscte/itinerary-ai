<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ItineraryController;

Route::get('/health', [ServerController::class, 'health']);

Route::post('/test', [ServerController::class, 'test']);

Route::post('/itinerary', [ItineraryController::class, 'createItinerary']);
