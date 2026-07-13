<?php

use App\Http\Controllers\ArticleDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleDashboardController::class)->middleware('article.ownership', ['only' => ['edit', 'update', 'destroy']]);
});
