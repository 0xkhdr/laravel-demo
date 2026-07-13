<?php

use App\Http\Controllers\ArticleDashboardController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class);

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleDashboardController::class)->middleware('article.ownership', ['only' => ['edit', 'update', 'destroy']]);
});
