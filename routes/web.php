<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Pemilik\DashboardController as PemilikDashboard;
use App\Http\Controllers\ProdukController as ProdukController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\Pemilik\AkunController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\pemilik\LaporanController;

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');


Route::middleware(['auth'])->group(function () {

    Route::get('/cetak-struk/{kode_transaksi}', [StrukController::class, 'show'])->name('transaksi.cetakStruk');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', ProdukController::class);
        
    });

    Route::middleware(['role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [KasirDashboard::class, 'index'])->name('dashboard');
        Route::post('/transaksi', [KatalogController::class, 'store'])->name('transaksi.store');
        
    });

    Route::middleware(['role:pemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
        Route::get('/dashboard', [PemilikDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', ProdukController::class);
        Route::post('/transaksi', [KatalogController::class, 'store'])->name('transaksi.store');
        Route::resource('akun', AkunController::class);
        Route::get('/riwayat-transaksi', [RiwayatTransaksiController::class, 'index'])->name('riwayat-transaksi.index');
        Route::delete('/riwayat-transaksi/{id}', [RiwayatTransaksiController::class, 'destroy'])->name('riwayat-transaksi.destroy');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    });
});
