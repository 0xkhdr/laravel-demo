<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('/users/{user}/activity', [UserController::class, 'activity'])->middleware('auth');
    Route::get('/users/{user}/preferences', [UserController::class, 'preferences'])->middleware('auth');
    Route::patch('/users/{user}/preferences', [UserController::class, 'updatePreferences'])->middleware('auth');
});

Route::get('/health', fn () => response()->json([
    'status' => 'ok',
    'application' => 'laravel-demo',
]));

Route::get('/users', [UserController::class, 'index']);
