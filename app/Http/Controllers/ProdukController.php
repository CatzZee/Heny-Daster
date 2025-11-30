<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Http\Requests\StoreProdukRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // GANTI Storage dengan File

class ProdukController extends Controller
{
    private function getRolePrefix(): string
    {
        $role = Auth::user()->role;
        if ($role === 'admin' || $role === 'pemilik') {
            return $role;
        }
        abort(403, 'Akses ditolak.');
    }

    public function index()
    {
        $routePrefix = $this->getRolePrefix();
        $viewPath = $routePrefix . '.manajemenProduk';
        $produks = Produk::with('kategori')->latest()->get();
        $kategoris = KategoriProduk::all();

        return view($viewPath, compact('produks', 'kategoris', 'routePrefix'));
    }

    public function create()
    {
        $routePrefix = $this->getRolePrefix();
        $viewPath = $routePrefix . '.produk.create';
        $kategoris = KategoriProduk::all();

        return view($viewPath, compact('kategoris', 'routePrefix'));
    }

    public function store(StoreProdukRequest $request)
    {
        $validatedData = $request->validated();

        // LOGIKA UPLOAD BARU (TANPA SYMLINK)
        if ($request->hasFile('path_gambar')) {
            $file = $request->file('path_gambar');
            
            // 1. Buat nama file unik
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // 2. Tentukan folder tujuan di public/uploads/produks
            $destinationPath = public_path('uploads/produks');

            // 3. Pastikan folder ada (Opsional, tapi praktik bagus)
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // 4. Pindahkan file
            $file->move($destinationPath, $fileName);

            // 5. Simpan path relatif ke database (agar bisa dipanggil dengan asset())
            $validatedData['path_gambar'] = 'uploads/produks/' . $fileName;
        }

        Produk::create($validatedData);

        $routePrefix = $this->getRolePrefix();
        return redirect()->route($routePrefix . '.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        $routePrefix = $this->getRolePrefix();
        $viewPath = $routePrefix . '.produk.show';
        return view($viewPath, compact('produk', 'routePrefix'));
    }

    public function edit(Produk $produk)
    {
        $routePrefix = $this->getRolePrefix();
        $viewPath = $routePrefix . '.produk.edit';
        $kategoris = KategoriProduk::all();

        return view($viewPath, compact('produk', 'kategoris', 'routePrefix'));
    }

    public function update(StoreProdukRequest $request, Produk $produk)
    {
        $validatedData = $request->validated();

        // LOGIKA UPDATE GAMBAR
        if ($request->hasFile('path_gambar')) {

            // A. Hapus file lama jika ada
            if ($produk->path_gambar && File::exists(public_path($produk->path_gambar))) {
                File::delete(public_path($produk->path_gambar));
            }

            // B. Upload file baru
            $file = $request->file('path_gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/produks');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file->move($destinationPath, $fileName);
            $validatedData['path_gambar'] = 'uploads/produks/' . $fileName;
        }

        $produk->update($validatedData);

        $routePrefix = $this->getRolePrefix();
        return redirect()->route($routePrefix . '.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $routePrefix = $this->getRolePrefix();

        try {
            if ($produk->detailTransaksis()->exists()) {
                return redirect()->route($routePrefix . '.produk.index')
                    ->with('error', 'Produk tidak bisa dihapus karena sudah ada di riwayat transaksi.');
            }

            // HAPUS GAMBAR FISIK
            if ($produk->path_gambar && File::exists(public_path($produk->path_gambar))) {
                File::delete(public_path($produk->path_gambar));
            }

            $produk->delete();

            return redirect()->route($routePrefix . '.produk.index')
                ->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route($routePrefix . '.produk.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}