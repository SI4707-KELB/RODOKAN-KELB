<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', function () {
    $hariIni = \App\Models\Laporan::whereDate('created_at', \Carbon\Carbon::today())->count();
    $aktif = \App\Models\Laporan::whereIn('status', ['Menunggu', 'Diproses', 'Darurat', 'Ditindaklanjuti'])->count();
    $selesai = \App\Models\Laporan::where('status', 'Selesai')->count();
    return view('auth.login', compact('hariIni', 'aktif', 'selesai'));
})->name('login');

Route::post('/login', [WebAuthController::class, 'login']);

Route::get('/register', function () {
    $hariIni = \App\Models\Laporan::whereDate('created_at', \Carbon\Carbon::today())->count();
    $aktif = \App\Models\Laporan::whereIn('status', ['Menunggu', 'Diproses', 'Darurat', 'Ditindaklanjuti'])->count();
    $selesai = \App\Models\Laporan::where('status', 'Selesai')->count();
    return view('auth.register', compact('hariIni', 'aktif', 'selesai'));
})->name('register');

Route::post('/register', [WebAuthController::class, 'register']);

Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan/buat', [\App\Http\Controllers\LaporanController::class, 'create'])->name('laporan.create');

    // Verifikasi Laporan Routes
    Route::prefix('verifikasi')->group(function () {
        Route::get('/', [\App\Http\Controllers\VerifikasiLaporanController::class, 'index'])->name('verifikasi.index');
        Route::post('/{id}/verifikasi', [\App\Http\Controllers\VerifikasiLaporanController::class, 'verifikasi'])->name('verifikasi.terima');
        Route::post('/{id}/tolak', [\App\Http\Controllers\VerifikasiLaporanController::class, 'tolak'])->name('verifikasi.tolak');
    });
});
