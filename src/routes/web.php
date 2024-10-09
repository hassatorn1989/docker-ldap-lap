<?php

use App\Http\Controllers\demo_controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo', [demo_controller::class, 'index']);
