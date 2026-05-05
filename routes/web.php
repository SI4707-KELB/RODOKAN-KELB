<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [WebAuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [WebAuthController::class, 'register']);

Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Verifikasi Laporan Routes
    Route::prefix('verifikasi')->group(function () {
        Route::get('/', [\App\Http\Controllers\VerifikasiLaporanController::class, 'index'])->name('verifikasi.index');
        Route::post('/{id}/verifikasi', [\App\Http\Controllers\VerifikasiLaporanController::class, 'verifikasi'])->name('verifikasi.terima');
        Route::post('/{id}/tolak', [\App\Http\Controllers\VerifikasiLaporanController::class, 'tolak'])->name('verifikasi.tolak');
    });
});
