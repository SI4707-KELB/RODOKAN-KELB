<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\User\LaporanController as UserLaporanController;
use App\Http\Controllers\Admin\VerifikasiLaporanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UpvoteController;

// Web Application Routes
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
    Route::get('/laporan/buat', [UserLaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan/buat', [UserLaporanController::class, 'store'])->name('laporan.store');
    Route::post('/laporan/{id}/upvote', [UpvoteController::class, 'toggle'])->name('laporan.upvote');
    Route::get('/laporan-saya', [UserLaporanController::class, 'user'])->name('laporan.saya');
    Route::get('/laporan-publik', [UserLaporanController::class, 'public'])->name('laporan.publik');
    Route::get('/laporan/{id}', [UserLaporanController::class, 'show'])->name('laporan.show');
    Route::post('/laporan/{id}/komentar', [KomentarController::class, 'store'])->name('komentar.store');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    Route::post('/laporan/check-duplicate', [UserLaporanController::class, 'checkDuplicate'])->name('laporan.check-duplicate');

    // Admin Only Routes within Auth
    Route::middleware('admin')->group(function () {
        // Verifikasi Laporan Routes
        Route::prefix('verifikasi')->group(function () {
            Route::get('/', [VerifikasiLaporanController::class, 'index'])->name('verifikasi.index');
            Route::get('/{id}', [VerifikasiLaporanController::class, 'show'])->name('verifikasi.show');
            Route::post('/{id}/verifikasi', [VerifikasiLaporanController::class, 'verifikasi'])->name('verifikasi.terima');
            Route::post('/{id}/tolak', [VerifikasiLaporanController::class, 'tolak'])->name('verifikasi.tolak');
            Route::get('/{id}/validasi', [VerifikasiLaporanController::class, 'getValidasi'])->name('verifikasi.getValidasi');
            Route::post('/{id}/validasi/update', [VerifikasiLaporanController::class, 'updateValidasi'])->name('verifikasi.updateValidasi');
        });
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Admin Laporan Management
    Route::prefix('laporan')->group(function () {
        Route::get('/', [AdminLaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/{id}', [AdminLaporanController::class, 'show'])->name('admin.laporan.show');
        Route::get('/{id}/edit', [AdminLaporanController::class, 'edit'])->name('admin.laporan.edit');
        Route::put('/{id}', [AdminLaporanController::class, 'update'])->name('admin.laporan.update');
        Route::delete('/{id}', [AdminLaporanController::class, 'destroy'])->name('admin.laporan.destroy');
        Route::post('/bulk-update', [AdminLaporanController::class, 'bulkUpdate'])->name('admin.laporan.bulk-update');
        Route::get('/stats/data', [AdminLaporanController::class, 'getStats'])->name('admin.laporan.stats');
        Route::get('/export/csv', [AdminLaporanController::class, 'export'])->name('admin.laporan.export');
        Route::get('/export/excel', [AdminLaporanController::class, 'exportExcel'])->name('admin.laporan.export.excel');
        Route::get('/export/pdf', [AdminLaporanController::class, 'exportPdf'])->name('admin.laporan.export.pdf');
    });

    Route::get('/export/excel', [AdminLaporanController::class, 'exportExcel'])->name('admin.dashboard.export.excel');
    Route::get('/export/pdf', [AdminLaporanController::class, 'exportPdf'])->name('admin.dashboard.export.pdf');
    Route::get('/export/csv', [AdminLaporanController::class, 'export'])->name('admin.dashboard.export.csv');

    // Admin Kategori Management
    Route::prefix('kategori')->group(function () {
        Route::get('/', [AdminKategoriController::class, 'index'])->name('admin.kategori.index');
        Route::get('/create', [AdminKategoriController::class, 'create'])->name('admin.kategori.create');
        Route::post('/', [AdminKategoriController::class, 'store'])->name('admin.kategori.store');
        Route::get('/{id}/edit', [AdminKategoriController::class, 'edit'])->name('admin.kategori.edit');
        Route::put('/{id}', [AdminKategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/{id}', [AdminKategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    });

    // Admin Pengaturan Management
    Route::get('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('admin.pengaturan.index');
});
