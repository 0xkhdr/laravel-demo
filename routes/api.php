<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json([
    'status' => 'ok',
    'application' => 'laravel-demo',
]));

Route::get('/users', [UserController::class, 'index']);
