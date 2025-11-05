<?php

use Illuminate\Support\Facades\Route;

Route::get('/kasir', function () {
    return view('../kasir/login');
});
Route::get('../kasir/loading', function () {
    return view('../kasir/loading');
});
Route::get('/wait/dasboard', function () {
    return view('../kasir/dasboard');
});
Route::get('/wait/dasboard/riwayat', function () {
    return view('../kasir/riwayat');
});
Route::get('/wait/dasboard/struk print', function () {
    return view('../kasir/strukR');
});
Route::get('/wait/dasboard/struk', function () {
    return view('../kasir/struk');
});


Route::get('/admin', function () {
    return view('../admin/login');
});
Route::get('/admin/loading', function () {
    return view('../admin/loading');
});
Route::get('/admin/dasboard/riwayat', function () {
    return view('../admin/riwayat');
});
Route::get('/admin/dasboard/akun', function () {
    return view('../admin/data');
});
Route::get('/admin/dasboard/akun/detail', function () {
    return view('../admin/ddetail');
});
Route::get('/admin/dasboard/akun/data baru', function () {
    return view('../admin/isiform');
});
Route::get('/admin/dasboard/stok barang', function () {
    return view('../admin/stok');
});



Route::get('/pemilik', function () {
    return view('../pemilik/login');
});
Route::get('/pemilik/loading', function () {
    return view('../pemilik/loading');
});
Route::get('/pemilik/dasboard', function () {
    return view('../pemilik/dasboard');
});
Route::get('/pemilik/dasboard/struk print', function () {
    return view('../pemilik/struk');
});
Route::get('/pemilik/stok barang', function () {
    return view('../pemilik/stok');
});
Route::get('/pemilik/riwayat', function () {
    return view('../pemilik/riwayat');
});
Route::get('/pemilik/dasboard/struk riwayat', function () {
    return view('../pemilik/strukR');
});
Route::get('/pemilik/dasboard/laporan', function () {
    return view('../pemilik/laporan');
});
Route::get('/pemilik/laporan grafik', function () {
    return view('../pemilik/grafik');
});
Route::get('/pemilik/dasboard/akun', function () {
    return view('../pemilik/data');
});
Route::get('/pemilik/dasboard/akun detail', function () {
    return view('../pemilik/ddetail');
});
Route::get('/pemilik/dasboard/akun/data baru', function () {
    return view('../pemilik/isiform');
});



