<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\KategoriProduk;

class DashboardController extends Controller
{
    private function getRolePrefix(): string
    {
        $role = Auth::user()->role;
        if (in_array($role, ['pemilik', 'kasir'])) {
            return $role;
        }
        abort(403, 'Akses ditolak.');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua produk (atau produk yang 'ready' saja)
        $produks = Produk::where('stok_produk', '>', 0)->get();
        $kategoris = KategoriProduk::all();

        // Ambil data lain yang mungkin Anda perlukan
        $routePrefix = $this->getRolePrefix(); // Anda sudah punya ini

        // Kirim data ke view
        return view('pemilik.dashboard', compact('produks', 'routePrefix', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
