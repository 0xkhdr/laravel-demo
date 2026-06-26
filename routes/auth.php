<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ProfileController;

// Registration routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/auth/register', [AuthController::class, 'register']);
});

// Login routes (guest only, with throttle on login)
Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1'); // 5 attempts per minute
});

// Logout route (auth required)
Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Email verification routes
Route::get('/auth/verify-email', [VerificationController::class, 'showVerifyEmailPage'])
    ->name('verify-email');
Route::get('/auth/verify', [VerificationController::class, 'verify'])
    ->name('verify');
Route::post('/auth/verify/resend', [VerificationController::class, 'resend'])
    ->middleware('throttle:1,1') // 1 attempt per minute
    ->name('verify-resend');

// Password reset routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/auth/forgot-password', [PasswordResetController::class, 'showForgotForm'])
        ->name('auth.forgot-password');
    Route::post('/auth/forgot-password', [PasswordResetController::class, 'forgotPassword']);
    Route::get('/auth/reset-password', [PasswordResetController::class, 'showResetForm'])
        ->name('auth.reset-password');
    Route::post('/auth/reset-password', [PasswordResetController::class, 'resetPassword']);
});

// Profile routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/profile', [ProfileController::class, 'show'])
        ->name('profile.show');
    Route::get('/dashboard/change-password', [ProfileController::class, 'showChangePasswordForm'])
        ->name('change-password');
    Route::post('/dashboard/change-password', [ProfileController::class, 'changePassword'])
        ->name('change-password.update');
});
