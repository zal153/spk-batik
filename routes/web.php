<?php

use App\Http\Controllers\Admin\AlternatifController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\RekapController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Breeze default dashboard
Route::get('/dashboard', [CustomerController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Group (requires auth)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kriteria & AHP
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::post('/kriteria/update-comparison', [KriteriaController::class, 'updateComparison'])->name('kriteria.update-comparison');
    Route::post('/kriteria/update-sub-comparison', [KriteriaController::class, 'updateSubComparison'])->name('kriteria.update-sub-comparison');
    Route::post('/kriteria/recalculate', [KriteriaController::class, 'recalculate'])->name('kriteria.recalculate');

    // Alternatif (Batik Catalog)
    Route::resource('alternatif', AlternatifController::class);

    // Rekap Laporan
    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/pdf', [RekapController::class, 'exportPdf'])->name('rekap.pdf');
    Route::delete('/rekap/{riwayat}', [RekapController::class, 'destroy'])->name('rekap.destroy');

    // Manajemen Akun
    Route::resource('users', UserController::class);
});

// Customer Group (requires auth)
Route::prefix('customer')->name('customer.')->middleware(['auth'])->group(function () {
    Route::get('/rekomendasi', [CustomerController::class, 'rekomendasi'])->name('rekomendasi');
    Route::post('/rekomendasi', [CustomerController::class, 'prosesRekomendasi'])->name('rekomendasi.proses');
    Route::get('/riwayat', [CustomerController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat/{riwayat}', [CustomerController::class, 'showRiwayat'])->name('riwayat.show');
    Route::delete('/riwayat/{riwayat}', [CustomerController::class, 'hapusRiwayat'])->name('riwayat.destroy');
});

require __DIR__.'/auth.php';
