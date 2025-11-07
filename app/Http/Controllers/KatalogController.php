<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- 1. WAJIB: Untuk Transaksi Database
use Illuminate\Support\Str; // <-- 2. WAJIB: Untuk generate Kode Transaksi

class KatalogController extends Controller
{
    /**
     * Helper untuk mendapatkan prefix role ('admin', 'pemilik', 'kasir', dll.)
     */
    private function getRolePrefix(): string
    {
        $role = Auth::user()->role;
        // Asumsi 'kasir' juga boleh akses, tambahkan sesuai kebutuhan
        if (in_array($role, [ 'pemilik', 'kasir'])) {
            return $role;
        }
        abort(403, 'Akses ditolak.');
    }

    /**
     * Menampilkan halaman Katalog (View Anda)
     */
    public function index()
    {
        $routePrefix = $this->getRolePrefix();

        // Asumsi nama view Anda adalah 'katalog.blade.php'
        $viewPath = $routePrefix . '.dashboard';

        $produks = Produk::with('kategori')->latest()->get();
        $kategoris = KategoriProduk::all();

        return view($viewPath, compact('produks', 'kategoris', 'routePrefix'));
    }

    /**
     * Menyimpan Transaksi baru
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'metode_pembayaran' => 'required|string|in:Tunai,Qris,Transfer',
            'total_harga' => 'required|numeric|min:0',
            'jumlah_bayar' => 'required|numeric|min:' . $request->total_harga, // Jumlah bayar tidak boleh kurang dari total
            'items' => 'required|array|min:1', // Harus ada setidaknya 1 item
            'items.*.produk_id' => 'required|integer|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric',
        ]);

        $routePrefix = $this->getRolePrefix();

        // 2. Gunakan DB::transaction
        // Ini memastikan jika ada 1 error (misal: stok gagal),
        // semua data (transaksi & detail) akan di-ROLLBACK (dibatalkan).
        try {
            DB::beginTransaction();

            // 3. Buat Transaksi (Data Induk)
            $transaksi = Transaksi::create([
                'id_pengguna' => Auth::id(), // ID Kasir/Admin yang login
                'kode_transaksi' => 'TRX-' . strtoupper(Str::random(10)),
                'waktu_transaksi' => now(),
                'total_harga' => $request->total_harga,
                'jumlah_bayar' => $request->jumlah_bayar,
                'kembalian' => $request->jumlah_bayar - $request->total_harga,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // 4. Loop dan Simpan Detail Transaksi + Kurangi Stok
            foreach ($request->items as $itemData) {
                // Ambil produk dari database
                $produk = Produk::find($itemData['produk_id']);

                // Cek ketersediaan stok
                if ($produk->stok_produk < $itemData['jumlah']) {
                    // Jika stok tidak cukup, batalkan transaksi
                    throw new \Exception('Stok untuk ' . $produk->nama_produk . ' tidak mencukupi.');
                }

                // Buat Detail Transaksi
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $itemData['produk_id'],
                    'jumlah' => $itemData['jumlah'],
                    'harga_saat_transaksi' => $itemData['harga'], // Harga saat beli
                ]);

                // Kurangi stok produk
                // 'decrement' adalah operasi database yang aman
                $produk->decrement('stok_produk', $itemData['jumlah']);
            }

            // 5. Jika semua berhasil, commit transaksi
            DB::commit();

            return redirect()->route($routePrefix . '.katalog.index')
                ->with('success', 'Transaksi berhasil disimpan! Kode: ' . $transaksi->kode_transaksi);
        } catch (\Exception $e) {
            // 6. Jika ada error, rollback semua
            DB::rollBack();

            // Kirim pesan error kembali ke view
            return redirect()->back()
                ->withInput() // Kembalikan input lama (keranjang, dll.)
                ->with('error', 'Transaksi Gagal: ' . $e->getMessage());
        }
    }
}
