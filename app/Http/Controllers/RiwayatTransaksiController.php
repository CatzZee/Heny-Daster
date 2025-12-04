<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksiController extends Controller
{
    /**
     * Helper untuk mendapatkan prefix role ('pemilik' atau 'kasir')
     */
    private function getRolePrefix(): string
    {
        $role = Auth::user()->role;
        if (in_array($role, ['pemilik', 'kasir'])) {
            return $role;
        }
        abort(403, 'Akses ditolak.');
    }

    /**
     * Menampilkan daftar riwayat transaksi.
     */
    public function index(Request $request)
    {
        $routePrefix = $this->getRolePrefix();
        $viewpath = $routePrefix . '.riwayatTransaksi';

        // START QUERY + RELASI
        // Mengambil relasi details.produk untuk keperluan modal detail & pencarian
        $query = Transaksi::with(['details.produk', 'pengguna']);

        // ==================== SEARCH ====================
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('nama_pembeli', 'like', "%$search%")
                  ->orWhere('kode_transaksi', 'like', "%$search%")
                  ->orWhere('metode_pembayaran', 'like', "%$search%");
            });

            // Search berdasarkan nama produk yang dibeli (menggunakan whereHas pada relasi nested)
            $query->orWhereHas('details.produk', function($q) use ($search) {
                $q->where('nama_produk', 'like', "%$search%");
            });
        }

        // ==================== FILTER TANGGAL ====================
        if ($request->filled('start_date')) {
            $query->whereDate('waktu_transaksi', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('waktu_transaksi', '<=', $request->end_date);
        }

        // ================= PAGINATION =================
        $perPage = $request->get('per_page', 10);

        $transaksis = $query->latest('waktu_transaksi')
                            ->paginate($perPage)
                            ->appends($request->query()); // appends() penting agar parameter search/filter tidak hilang saat pindah halaman

        return view($viewpath, compact('transaksis', 'routePrefix'));
    }

    /**
     * Menghapus data transaksi.
     */
    public function destroy($id)
    {
        // Mencari data transaksi berdasarkan ID, jika tidak ketemu akan otomatis 404
        $transaksi = Transaksi::findOrFail($id);

        // Menghapus data
        // Karena di database biasanya ada foreign key constraint pada detail_transaksi,
        // pastikan migrasi kamu menggunakan 'onDelete("cascade")' atau model event boot() untuk membersihkan child rows.
        // Jika sudah di-set cascade di database, baris ini cukup.
        $transaksi->delete();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data transaksi berhasil dihapus.');
    }
}