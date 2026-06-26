<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LandingController;

Route::get('/', [LandingController::class, 'index']);
