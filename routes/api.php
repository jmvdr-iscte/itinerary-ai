<?php

use App\Http\Controllers\ServerController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;

Route::get('/health', [ServerController::class, 'health']);

Route::post('/test', [ServerController::class, 'test']);

Route::post('/itinerary', [ItineraryController::class, 'createItinerary']);

Route::middleware('api_key')->group(function () {
    Route::post('/product', [ProductsController::class, 'createProduct']);
    Route::patch('/product/{uid}', [ProductsController::class, 'updateProduct']);
});

Route::post('/transactions', [TransactionsController::class, 'createTransaction']);

Route::get("/transactions/{uid}", [TransactionsController::class, 'getTransaction']);

Route::post('/transaction-callback/stripe', [TransactionsController::class, 'handleCallback']);

Route::get('/product', [ProductsController::class, 'getProduct']);

Route::post('user/email', [UserController::class, 'saveEmail']);

Route::post('user/support', [UserController::class, 'supportUser']);
