<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;

// Login routes
Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/', [UsuariosController::class, 'login'])->name('login');

// Registration routes
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [UsuariosController::class, 'registrarUsuario'])->middleware('web');

Route::post('/logout', [UsuariosController::class, 'logOut'])->name('logout');

