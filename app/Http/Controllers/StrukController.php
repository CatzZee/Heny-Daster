<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StrukController extends Controller
{
    /**
     * Tampilkan halaman cetak struk.
     */
    public function show($kode_transaksi)
    {
        // 1. Ambil data transaksi berdasarkan kodenya
        // 'with' mengambil relasi: 'details' (barang) -> 'produk' (info produk)
        // dan 'pengguna' (info kasir)
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)
                            ->with(['details.produk', 'pengguna'])
                            ->firstOrFail(); // Error jika tidak ketemu

        // 2. Dapatkan role user yang sedang login
        $role = Auth::user()->role; // 'kasir' atau 'pemilik'

        // 3. Tampilkan view cetakStruk sesuai role
        // Kita akan kirim data $transaksi ke view
        return view($role . '.cetakStruk', compact('transaksi'));
    }
}