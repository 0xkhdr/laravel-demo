<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => ['data' => ['status' => 'ok']]);
Route::get('/users', [UserController::class, 'index']);
