<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServerController;

Route::get('/health',[ServerController::class, 'health']);
