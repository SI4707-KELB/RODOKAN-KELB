<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Web Application Routes
Route::get('/', [HomeController::class, 'index']);

Route::get('/login', function () {
    return redirect('/');
})->name('login');

Route::get('/register', function () {
    return redirect('/');
})->name('register');
