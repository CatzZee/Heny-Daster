<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksi extends Controller
{
    private function resolveView($viewName)
    {
        $role = Auth::user()->role ?? 'kasir';

        if ($role === 'admin') {
            return "admin.$viewName";
        }

        if ($role === 'kasir') {
            return "kasir.$viewName";
        }

        // fallback untuk pemilik
        return "pemilik.$viewName";
    }

    public function index(Request $request)
    {
        $query = DB::table('transaksis')
            ->select('transaksis.*', 'users.name as nama_user')
            ->leftJoin('users', 'transaksis.id_pengguna', '=', 'users.id')
            ->orderBy('transaksis.created_at', 'desc');

        // Filter tanggal
        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('transaksis.created_at', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('transaksis.status', $request->status);
        }

        // Filter user sesuai role
        $userRole = Auth::user()->role ?? 'kasir';
        if (!in_array($userRole, ['admin', 'pemilik'])) {
            $query->where('transaksis.id_pengguna', Auth::id());
        }

        $transaksi = $query->paginate(15);

        return view($this->resolveView('riwayatTransaksi'), compact('transaksi'));
    }

    public function show($id)
    {
        $transaksi = DB::table('transaksis')
            ->select('transaksis.*', 'users.name as nama_user', 'users.email')
            ->leftJoin('users', 'transaksis.id_pengguna', '=', 'users.id')
            ->where('transaksis.id', $id)
            ->first();

        if (!$transaksi) {
            return redirect()->route('riwayat-transaksi.index')
                ->with('error', 'Transaksi tidak ditemukan');
        }

        // Cek akses
        $userRole = Auth::user()->role ?? 'kasir';
        if (!in_array($userRole, ['admin', 'pemilik']) && $transaksi->id_pengguna != Auth::id()) {
            return redirect()->route('riwayat-transaksi.index')
                ->with('error', 'Anda tidak memiliki akses ke transaksi ini');
        }

        $detail_transaksi = DB::table('detail_transaksis')
            ->select('detail_transaksis.*', 'produks.nama_produk', 'produks.harga_produk as harga')
            ->leftJoin('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
            ->where('detail_transaksis.transaksi_id', $id)
            ->get();

        return view($this->resolveView('riwayatTransaksi'), compact('transaksi', 'detail_transaksi'));
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'pdf');

        $query = DB::table('transaksis')
            ->select('transaksis.*', 'users.name as nama_user')
            ->leftJoin('users', 'transaksis.id_pengguna', '=', 'users.id')
            ->orderBy('transaksis.created_at', 'desc');

        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('transaksis.created_at', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        }

        $userRole = Auth::user()->role ?? 'kasir';
        if (!in_array($userRole, ['admin', 'pemilik'])) {
            $query->where('transaksis.id_pengguna', Auth::id());
        }

        $transaksi = $query->get();

        if ($format == 'pdf') {
            return response()->json(['message' => 'Export PDF - implementasi sesuai library']);
        } else {
            return response()->json(['message' => 'Export Excel - implementasi sesuai library']);
        }
    }

    public function statistik(Request $request)
    {
        $query = DB::table('transaksis');

        $userRole = Auth::user()->role ?? 'kasir';
        if (!in_array($userRole, ['admin', 'pemilik'])) {
            $query->where('id_pengguna', Auth::id());
        }

        $periode = $request->get('periode', 'bulan_ini');

        switch ($periode) {
            case 'hari_ini':
                $query->whereDate('created_at', today());
                break;
            case 'minggu_ini':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'bulan_ini':
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                break;
            case 'tahun_ini':
                $query->whereYear('created_at', now()->year);
                break;
        }

        $statistik = [
            'total_transaksi'      => $query->count(),
            'total_pendapatan'     => $query->sum('total_harga'),
            'transaksi_sukses'     => (clone $query)->where('status', 'selesai')->count(),
            'transaksi_pending'    => (clone $query)->where('status', 'pending')->count(),
            'transaksi_dibatalkan' => (clone $query)->where('status', 'dibatalkan')->count(),
        ];

        return view($this->resolveView('riwayatTransaksi'), compact('statistik', 'periode'));
    }

    public function cancel($id)
    {
        $transaksi = DB::table('transaksis')->where('id', $id)->first();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        $userRole = Auth::user()->role ?? 'kasir';
        if (!in_array($userRole, ['admin', 'pemilik']) && $transaksi->id_pengguna != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        if ($transaksi->status != 'pending') {
            return redirect()->back()->with('error', 'Transaksi tidak dapat dibatalkan');
        }

        DB::table('transaksis')
            ->where('id', $id)
            ->update([
                'status' => 'dibatalkan',
                'updated_at' => now()
            ]);

        return redirect()->route('riwayat-transaksi.index')
            ->with('success', 'Transaksi berhasil dibatalkan');
    }

    public function printInvoice($id)
    {
        $transaksi = DB::table('transaksis')
            ->select('transaksis.*', 'users.name as nama_user', 'users.email')
            ->leftJoin('users', 'transaksis.id_pengguna', '=', 'users.id')
            ->where('transaksis.id', $id)
            ->first();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        $userRole = Auth::user()->role ?? 'kasir';
        if (!in_array($userRole, ['admin', 'pemilik']) && $transaksi->id_pengguna != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $detail_transaksi = DB::table('detail_transaksis')
            ->select('detail_transaksis.*', 'produks.nama_produk', 'produks.harga_produk as harga')
            ->leftJoin('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
            ->where('detail_transaksis.transaksi_id', $id)
            ->get();

        return view($this->resolveView('riwayatTransaksi'), compact('transaksi', 'detail_transaksi'));
    }
}
