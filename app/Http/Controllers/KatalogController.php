<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;
use App\Http\Requests\StoreTransaksiRequest; // (BARU) Import Request kustom kita

class KatalogController extends Controller
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
     * Menampilkan halaman Katalog (View Dashboard)
     */
    public function index()
    {
        $routePrefix = $this->getRolePrefix();
        $viewPath = $routePrefix . '.dashboard'; // Misal: 'kasir.dashboard'

        $produks = Produk::with('kategori')->latest()->get();
        $kategoris = KategoriProduk::all();

        return view($viewPath, compact('produks', 'kategoris', 'routePrefix'));
    }

    /**
     * Menyimpan Transaksi baru
     * (MODIFIKASI) Menggunakan StoreTransaksiRequest dan mengembalikan JSON
     */
    public function store(StoreTransaksiRequest $request) // <-- (MODIFIKASI)
    {
        // (DIHAPUS) Blok $request->validate() sudah tidak ada,
        // karena otomatis ditangani oleh StoreTransaksiRequest.

        try {
            DB::beginTransaction();

            // 3. Buat Transaksi (Data Induk)
            $transaksi = Transaksi::create([
                'id_pengguna' => Auth::id(),
                'nama_pembeli' => $request->nama_pembeli, // <-- (BARU) Sesuai alur
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
                // (MODIFIKASI) Gunakan 'lockForUpdate' untuk mencegah race condition stok
                $produk = Produk::lockForUpdate()->find($itemData['produk_id']);

                // Cek ketersediaan stok
                if ($produk->stok_produk < $itemData['jumlah']) {
                    throw new \Exception('Stok untuk ' . $produk->nama_produk . ' tidak mencukupi.');
                }

                // Buat Detail Transaksi
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $itemData['produk_id'],
                    'jumlah' => $itemData['jumlah'],
                    'harga_saat_transaksi' => $itemData['harga'], 
                ]);

                // Kurangi stok produk
                $produk->decrement('stok_produk', $itemData['jumlah']);
            }

            // 5. Jika semua berhasil, commit transaksi
            DB::commit();

            // (MODIFIKASI) Kirim respons JSON sukses
            return response()->json([
                'success' => 'Transaksi berhasil disimpan! Kode: ' . $transaksi->kode_transaksi
            ], 200); // 200 = OK

        } catch (\Exception $e) {
            // 6. Jika ada error, rollback semua
            DB::rollBack();

            // (MODIFIKASI) Kirim respons JSON error
            return response()->json([
                'error' => 'Transaksi Gagal: ' . $e->getMessage()
            ], 500); // 500 = Internal Server Error
        }
    }
}