<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Pemilik\DashboardController as PemilikDashboard;
use App\Http\Controllers\ProdukController as ProdukController;

// === RUTE TAMU (Tidak Perlu Login) ===
// Tidak ada middleware 'auth' di sini
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');


// === RUTE PENGHUNI (WAJIB LOGIN) ===
// # ALUR A: "Satpam Gerbang Utama"
// Semua rute di dalam grup ini akan dicek oleh middleware 'auth'
Route::middleware(['auth'])->group(function () {

    // # ALUR B: "Penjaga Pintu Unit Admin"
    // Hanya user dengan role 'admin' yang boleh masuk
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', ProdukController::class);
    });

    // # ALUR C: "Penjaga Pintu Unit Kasir"
    // Hanya user dengan role 'kasir' yang boleh masuk
    Route::middleware(['role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [KasirDashboard::class, 'index'])->name('dashboard');
        // ...rute kasir lainnya...
    });

    // # ALUR D: "Penjaga Pintu Unit Pemilik"
    // Hanya user dengan role 'pemilik' yang boleh masuk
    Route::middleware(['role:pemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
        Route::get('/dashboard', [PemilikDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', ProdukController::class);
        Route::post('/transaksi', [KatalogController::class, 'store'])->name('transaksi.store');
    });

}); // <-- Akhir dari grup 'auth'
