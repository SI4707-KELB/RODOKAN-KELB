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

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Admin Laporan Management
    Route::prefix('laporan')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminLaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/{id}', [\App\Http\Controllers\AdminLaporanController::class, 'show'])->name('admin.laporan.show');
        Route::get('/{id}/edit', [\App\Http\Controllers\AdminLaporanController::class, 'edit'])->name('admin.laporan.edit');
        Route::put('/{id}', [\App\Http\Controllers\AdminLaporanController::class, 'update'])->name('admin.laporan.update');
        Route::delete('/{id}', [\App\Http\Controllers\AdminLaporanController::class, 'destroy'])->name('admin.laporan.destroy');
        Route::post('/bulk-update', [\App\Http\Controllers\AdminLaporanController::class, 'bulkUpdate'])->name('admin.laporan.bulk-update');
        Route::get('/stats/data', [\App\Http\Controllers\AdminLaporanController::class, 'getStats'])->name('admin.laporan.stats');
        Route::get('/export/csv', [\App\Http\Controllers\AdminLaporanController::class, 'export'])->name('admin.laporan.export');
    });

    // Admin Kategori Management
    Route::prefix('kategori')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminKategoriController::class, 'index'])->name('admin.kategori.index');
        Route::get('/create', [\App\Http\Controllers\AdminKategoriController::class, 'create'])->name('admin.kategori.create');
        Route::post('/', [\App\Http\Controllers\AdminKategoriController::class, 'store'])->name('admin.kategori.store');
        Route::get('/{id}/edit', [\App\Http\Controllers\AdminKategoriController::class, 'edit'])->name('admin.kategori.edit');
        Route::put('/{id}', [\App\Http\Controllers\AdminKategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/{id}', [\App\Http\Controllers\AdminKategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    });
});
