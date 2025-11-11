<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Http\Requests\StoreProdukRequest; // Request validasi kita
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Untuk mengelola file (gambar)

class ProdukController extends Controller
{
    /**
     * Helper method untuk mendapatkan prefix role ('admin' atau 'pemilik').
     * Ini akan kita gunakan untuk menentukan path View dan nama Rute.
     */
    private function getRolePrefix(): string
    {
        // Kita bisa panggil Auth::user() karena rute ini sudah dilindungi
        // oleh middleware 'auth'.
        $role = Auth::user()->role;

        if ($role === 'admin' || $role === 'pemilik') {
            return $role;
        }

        // Ini adalah fallback, seharusnya tidak akan pernah terjadi
        // karena rute sudah dilindungi middleware 'role'.
        abort(403, 'Akses ditolak.');
    }

    /**
     * READ (Daftar Produk)
     * Method: GET
     * Rute: admin.produk.index ATAU pemilik.produk.index
     */
    public function index()
    {
        // 1. Ambil prefix (cth: 'admin')
        $routePrefix = $this->getRolePrefix();

        // 2. Tentukan path view (cth: 'admin.produk.index')
        $viewPath = $routePrefix . '.manajemenProduk';

        // 3. Ambil data dari database
        // 'with('kategori')' -> Eager Loading, sangat penting untuk performa
        // agar tidak terjadi N+1 query problem di view.
        $produks = Produk::with('kategori')->latest()->get();

        // 4. [PERBAIKAN] Ambil data kategori untuk modal dropdown
        $kategoris = KategoriProduk::all();

        // 4. Kirim data ke view yang benar
        return view($viewPath, compact('produks', 'kategoris', 'routePrefix'));
    }

    /**
     * CREATE (Tampil Form)
     * Method: GET
     * Rute: admin.produk.create ATAU pemilik.produk.create
     */
    public function create()
    {
        // 1. Ambil prefix
        $routePrefix = $this->getRolePrefix();

        // 2. Tentukan path view
        $viewPath = $routePrefix . '.produk.create';

        // 3. Ambil data kategori (untuk dropdown <select>)
        $kategoris = KategoriProduk::all();

        // 4. Kirim data ke view
        return view($viewPath, compact('kategoris', 'routePrefix'));
    }

    /**
     * STORE (Simpan Data Baru)
     * Method: POST
     * Rute: admin.produk.store ATAU pemilik.produk.store
     */
    public function store(StoreProdukRequest $request)
    {
        // 1. Validasi terjadi OTOMATIS berkat StoreProdukRequest.
        //    Jika gagal, Laravel otomatis redirect kembali ke form.

        // 2. Ambil semua data yang sudah lolos validasi
        $validatedData = $request->validated();

        // 3. Logika Handle File Upload
        if ($request->hasFile('path_gambar')) {
            // 'produks' -> nama folder di dalam 'storage/app/public'
            // 'public' -> nama disk (merujuk ke 'config/filesystems.php')
            $path = $request->file('path_gambar')->store('produks', 'public');

            // Simpan path (cth: "produks/namagambar.jpg") ke database
            $validatedData['path_gambar'] = $path;
        }

        // 4. Buat produk baru di database
        // Ini aman karena $fillable di Model Produk sudah kita atur
        Produk::create($validatedData);

        // 5. Redirect kembali ke halaman index DENGAN dinamis
        $routePrefix = $this->getRolePrefix();
        return redirect()->route($routePrefix . '.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * SHOW (Tampil Detail) - Opsional
     * Method: GET
     * Rute: admin.produk.show/{produk} ATAU pemilik.produk.show/{produk}
     */
    public function show(Produk $produk)
    {
        // $produk sudah otomatis diambil oleh Route Model Binding
        $routePrefix = $this->getRolePrefix();
        $viewPath = $routePrefix . '.produk.show'; // cth: 'admin.produk.show'

        // Anda harus membuat file view 'show.blade.php' jika ingin pakai ini
        return view($viewPath, compact('produk', 'routePrefix'));
    }

    /**
     * EDIT (Tampil Form Edit)
     * Method: GET
     * Rute: admin.produk.edit/{produk} ATAU pemilik.produk.edit/{produk}
     */
    public function edit(Produk $produk)
    {
        // $produk sudah ada berkat Route Model Binding

        // 1. Ambil prefix
        $routePrefix = $this->getRolePrefix();

        // 2. Tentukan path view
        $viewPath = $routePrefix . '.produk.edit';

        // 3. Ambil data kategori (untuk dropdown <select>)
        $kategoris = KategoriProduk::all();

        // 4. Kirim data (produk yg mau diedit, kategori, prefix) ke view
        return view($viewPath, compact('produk', 'kategoris', 'routePrefix'));
    }

    /**
     * UPDATE (Simpan Perubahan)
     * Method: PUT/PATCH
     * Rute: admin.produk.update/{produk} ATAU pemilik.produk.update/{produk}
     */
    public function update(StoreProdukRequest $request, Produk $produk)
    {
        // 1. Validasi terjadi OTOMATIS.
        // 2. $produk sudah ada berkat Route Model Binding.

        $validatedData = $request->validated();

        // 3. Logika Handle File Upload (Update)
        if ($request->hasFile('path_gambar')) {

            // A. Hapus file lama jika ada
            if ($produk->path_gambar) {
                Storage::disk('public')->delete($produk->path_gambar);
            }

            // B. Simpan file baru
            $path = $request->file('path_gambar')->store('produks', 'public');
            $validatedData['path_gambar'] = $path;
        }

        // 4. Update data produk di database
        $produk->update($validatedData);

        // 5. Redirect dinamis
        $routePrefix = $this->getRolePrefix();
        return redirect()->route($routePrefix . '.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * DESTROY (Hapus Data)
     * Method: DELETE
     * Rute: admin.produk.destroy/{produk} ATAU pemilik.produk.destroy/{produk}
     */
    /**
     * Hapus produk dari database.
     */
    /**
     * Hapus produk dari database.
     */
    public function destroy(Produk $produk)
    {
        // (BARU) Ambil prefix role yang sedang login
        $routePrefix = $this->getRolePrefix();

        try {
            // 1. Cek dulu apakah produk ini ada di 'detail_transaksis'
            if ($produk->detailTransaksis()->exists()) {
                // (MODIFIKASI) Gunakan $routePrefix
                return redirect()->route($routePrefix . '.produk.index')
                    ->with('error', 'Produk tidak bisa dihapus karena sudah ada di riwayat transaksi.');
            }

            // 2. Jika aman (tidak ada di transaksi), baru hapus
            if ($produk->path_gambar) {
                Storage::disk('public')->delete($produk->path_gambar);
            }

            $produk->delete();

            // (MODIFIKASI) Gunakan $routePrefix
            return redirect()->route($routePrefix . '.produk.index')
                ->with('success', 'Produk berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // 3. (Pengaman) Tangkap error SQL
            // (MODIFIKASI) Gunakan $routePrefix
            return redirect()->route($routePrefix . '.produk.index')
                ->with('error', 'Gagal menghapus produk. Produk ini terkait dengan data lain.');
        } catch (\Exception $e) {
            // 4. (Pengaman) Tangkap error lainnya
            // (MODIFIKASI) Gunakan $routePrefix
            return redirect()->route($routePrefix . '.produk.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
