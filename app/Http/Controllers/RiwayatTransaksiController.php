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
    $query = Transaksi::with(['details.produk', 'pengguna']);

    // ==================== SEARCH ====================
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function($q) use ($search) {
            $q->where('nama_pembeli', 'like', "%$search%")
              ->orWhere('kode_transaksi', 'like', "%$search%")
              ->orWhere('metode_pembayaran', 'like', "%$search%");
        });

        // search berdasarkan nama produk
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


    /// ================= PAGINATION =================
$perPage = $request->get('per_page', 10);

$transaksis = $query->latest('waktu_transaksi')
                    ->paginate($perPage)
                    ->appends($request->query());


    return view($viewpath, compact('transaksis', 'routePrefix'));
}
};