<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pathframe-demo', fn () => response()->json(['status' => 'ok']));
