<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;

// Login routes
Route::get('/', function () {
    return view('welcome');
})->name('login');

// Registration routes
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [UsuariosController::class, 'registrarUsuario'])->middleware('web');

