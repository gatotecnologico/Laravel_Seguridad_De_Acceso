<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Login routes
Route::get('/', function () {
    return view('welcome');
})->name('login');

// Registration routes
Route::get('/register', function () {
    return view('register');
})->name('register');
