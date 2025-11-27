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
    public function index()
    {
        $routePrefix = $this->getRolePrefix();
        $viewpath = $routePrefix . '.riwayatTransaksi';
        $transaksis = Transaksi::latest('waktu_transaksi')->paginate(10);

        return view( $viewpath , compact('transaksis', 'routePrefix'));
    }

    /**
     * Menghapus transaksi tertentu.
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Hapus data transaksi (Detail transaksi akan ikut terhapus jika on delete cascade diatur di database, 
        // atau Anda bisa menghapusnya manual jika perlu)
        $transaksi->delete();

        return redirect()->route('pemilik.riwayat-transaksi.index')
            ->with('success', 'Data transaksi berhasil dihapus.');
    }
}
