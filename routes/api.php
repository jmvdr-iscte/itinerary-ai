<?php

use App\Http\Controllers\ServerController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;

Route::get('/health', [ServerController::class, 'health']);

Route::post('/test', [ServerController::class, 'test']);

Route::post('/itinerary', [ItineraryController::class, 'createItinerary']);

Route::middleware('api_key')->group(function () {
    Route::post('/product', [ProductsController::class, 'createProduct']);
});

Route::post('/transactions', [TransactionsController::class, 'createTransaction']);

Route::get("/transactions/{uid}", [TransactionsController::class, 'getTransaction']);
