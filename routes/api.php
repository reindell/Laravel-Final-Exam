<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// --- PUBLIC ROUTES (No Token Needed) ---
Route::post('/login', [ApiController::class, 'login']);
Route::post('/register', [ApiController::class, 'register']);
Route::post('/user/update', [ApiController::class, 'updateProfile']);
Route::post('/orders/save', [ApiController::class, 'order']);

// Move these here so Flutter can see them without a token
Route::get('/foods', [ApiController::class, 'getFoods']);
Route::get('/orders', [ApiController::class, 'getOrders']);

// --- PROTECTED ROUTES ---
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ApiController::class, 'profile']);
    Route::post('/foods/add', [ApiController::class, 'addFood']);
});
