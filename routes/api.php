<?php

\Illuminate\Support\Facades\Route::get('/ping', fn () => ['data' => ['status' => 'ok']]);
