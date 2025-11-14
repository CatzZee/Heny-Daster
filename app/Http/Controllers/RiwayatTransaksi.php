<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('transaksi')
            ->select('transaksi.*', 'users.name as nama_user')
            ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
            ->orderBy('transaksi.created_at', 'desc');

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('transaksi.created_at', [
                $request->tanggal_mulai, 
                $request->tanggal_selesai
            ]);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('transaksi.status', $request->status);
        }

        // Filter berdasarkan user (jika bukan admin)
        if (!Auth::user()->is_admin) {
            $query->where('transaksi.user_id', Auth::id());
        }

        $transaksi = $query->paginate(15);

        return view('riwayat-transaksi.index', compact('transaksi'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = DB::table('transaksi')
            ->select('transaksi.*', 'users.name as nama_user', 'users.email')
            ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
            ->where('transaksi.id', $id)
            ->first();

        if (!$transaksi) {
            return redirect()->route('riwayat-transaksi.index')
                ->with('error', 'Transaksi tidak ditemukan');
        }

        // Cek authorization - user hanya bisa lihat transaksi sendiri
        if (!Auth::user()->is_admin && $transaksi->user_id != Auth::id()) {
            return redirect()->route('riwayat-transaksi.index')
                ->with('error', 'Anda tidak memiliki akses ke transaksi ini');
        }

        // Ambil detail transaksi
        $detail_transaksi = DB::table('detail_transaksi')
            ->select('detail_transaksi.*', 'produk.nama_produk', 'produk.harga')
            ->leftJoin('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->where('detail_transaksi.transaksi_id', $id)
            ->get();

        return view('riwayat-transaksi.show', compact('transaksi', 'detail_transaksi'));
    }

    /**
     * Export transaksi to PDF/Excel
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'pdf'); // pdf atau excel

        $query = DB::table('transaksi')
            ->select('transaksi.*', 'users.name as nama_user')
            ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
            ->orderBy('transaksi.created_at', 'desc');

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('transaksi.created_at', [
                $request->tanggal_mulai, 
                $request->tanggal_selesai
            ]);
        }

        // Filter berdasarkan user (jika bukan admin)
        if (!Auth::user()->is_admin) {
            $query->where('transaksi.user_id', Auth::id());
        }

        $transaksi = $query->get();

        if ($format == 'pdf') {
            // Implementasi export PDF
            // return PDF::loadView('riwayat-transaksi.pdf', compact('transaksi'))->download('riwayat-transaksi.pdf');
            return response()->json(['message' => 'Export PDF - implementasi sesuai library yang digunakan']);
        } else {
            // Implementasi export Excel
            // return Excel::download(new TransaksiExport($transaksi), 'riwayat-transaksi.xlsx');
            return response()->json(['message' => 'Export Excel - implementasi sesuai library yang digunakan']);
        }
    }

    /**
     * Get statistics
     */
    public function statistik(Request $request)
    {
        $query = DB::table('transaksi');

        // Filter berdasarkan user (jika bukan admin)
        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        // Filter berdasarkan periode
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
            'total_transaksi' => $query->count(),
            'total_pendapatan' => $query->sum('total_harga'),
            'transaksi_sukses' => $query->where('status', 'selesai')->count(),
            'transaksi_pending' => $query->where('status', 'pending')->count(),
            'transaksi_dibatalkan' => $query->where('status', 'dibatalkan')->count(),
        ];

        return view('riwayat-transaksi.statistik', compact('statistik', 'periode'));
    }

    /**
     * Cancel transaction
     */
    public function cancel($id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->first();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        // Cek authorization
        if (!Auth::user()->is_admin && $transaksi->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        // Cek apakah transaksi bisa dibatalkan
        if ($transaksi->status != 'pending') {
            return redirect()->back()->with('error', 'Transaksi tidak dapat dibatalkan');
        }

        DB::table('transaksi')
            ->where('id', $id)
            ->update([
                'status' => 'dibatalkan',
                'updated_at' => now()
            ]);

        return redirect()->route('riwayat-transaksi.index')
            ->with('success', 'Transaksi berhasil dibatalkan');
    }

    /**
     * Print invoice
     */
    public function printInvoice($id)
    {
        $transaksi = DB::table('transaksi')
            ->select('transaksi.*', 'users.name as nama_user', 'users.email', 'users.telepon')
            ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
            ->where('transaksi.id', $id)
            ->first();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        // Cek authorization
        if (!Auth::user()->is_admin && $transaksi->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $detail_transaksi = DB::table('detail_transaksi')
            ->select('detail_transaksi.*', 'produk.nama_produk', 'produk.harga')
            ->leftJoin('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->where('detail_transaksi.transaksi_id', $id)
            ->get();

        return view('riwayat-transaksi.invoice', compact('transaksi', 'detail_transaksi'));
    }
}