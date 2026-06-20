<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);

// Auth routes
Route::post('/auth/register', RegisterController::class);
Route::post('/auth/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/profile', MeController::class);
    Route::post('/auth/logout', LogoutController::class);
});
