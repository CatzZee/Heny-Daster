<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi; // Pastikan model ini ada
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    private function getRolePrefix(): string
    {
        $role = Auth::user()->role;
        if ($role === 'admin' || $role === 'pemilik') {
            return $role;
        }
        abort(403, 'Akses ditolak.');
    }
    public function index(Request $request)
    {
        $routePrefix = $this->getRolePrefix();
        // 1. Ambil input filter Bulan & Tahun (Default: Bulan & Tahun saat ini)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // 2. Data A: Laporan Keuangan Harian (Grafik & Tabel Rekap)
        // Mengelompokkan transaksi per tanggal
        $laporanHarian = Transaksi::selectRaw('DATE(waktu_transaksi) as tanggal, SUM(total_harga) as total_pendapatan, COUNT(id) as jumlah_transaksi')
            ->whereMonth('waktu_transaksi', $bulan)
            ->whereYear('waktu_transaksi', $tahun)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Siapkan array untuk Chart.js
        $chartLabels = $laporanHarian->pluck('tanggal')->map(function($date){
            return Carbon::parse($date)->format('d M');
        })->toArray();
        $chartData = $laporanHarian->pluck('total_pendapatan')->toArray();

        // 3. Data B: Top 5 Produk Terlaris Bulan Ini
        // Join dari detail_transaksi ke produk, lalu ke transaksi untuk filter bulan
        $topProduk = DetailTransaksi::select('produks.nama_produk', DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'))
            ->join('produks', 'produks.id', '=', 'detail_transaksis.id_produk')
            ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.id_transaksi')
            ->whereMonth('transaksis.waktu_transaksi', $bulan)
            ->whereYear('transaksis.waktu_transaksi', $tahun)
            ->groupBy('produks.id', 'produks.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return view('pemilik.laporan', compact(
            'laporanHarian', 
            'topProduk', 
            'chartLabels', 
            'chartData',
            'bulan',
            'tahun',
            'routePrefix'
        ));
    }
}