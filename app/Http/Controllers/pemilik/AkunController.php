<?php

namespace App\Http\Controllers\Pemilik; // (Namespace kamu sudah benar)

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    /**
     * Helper untuk mendapatkan prefix role (misal 'pemilik')
     */
    private function getRolePrefix(): string
    {
        return Auth::user()->role;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        $routePrefix = $this->getRolePrefix();

        // (MODIFIKASI) Pastikan view ini ada: 'resources/views/pemilik/dataAkun.blade.php'
        return view('pemilik.dataAkun', compact('users', 'routePrefix'));
    }

    /**
     * Show the form for creating a new resource.
     * (Route resource otomatis membuat ini, tapi kita pakai modal, jadi biarkan kosong)
     */
    public function create()
    {
        // Kita tidak pakai halaman 'create' terpisah, kita pakai modal di 'index'
        return redirect()->route($this->getRolePrefix() . '.akun.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:users,nama',
            'role' => 'required|in:admin,kasir,pemilik',
            'password' => 'required|string|min:8|confirmed',
            'path_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('path_gambar')) {
            $path = $request->file('path_gambar')->store('gambar_akun', 'public');
        }

        User::create([
            'nama' => $validated['nama'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'path_gambar' => $path,
        ]);

        // (MODIFIKASI) Redirect ke route yang benar
        return redirect()->route($this->getRolePrefix() . '.akun.index')
            ->with('success', 'Akun baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Tidak kita pakai)
     */
    public function show(User $akun)
    {
        return redirect()->route($this->getRolePrefix() . '.akun.index');
    }

    /**
     * Show the form for editing the specified resource.
     * (Tidak kita pakai, kita pakai modal)
     */
    public function edit(User $akun)
    {
        return redirect()->route($this->getRolePrefix() . '.akun.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $akun)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($akun->id),
            ],
            'role' => 'required|in:admin,kasir,pemilik',
            'password' => 'nullable|string|min:8|confirmed',
            'path_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $akun->nama = $validated['nama'];
        $akun->role = $validated['role'];

        if ($request->filled('password')) {
            $akun->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('path_gambar')) {
            if ($akun->path_gambar) {
                Storage::disk('public')->delete($akun->path_gambar);
            }
            $path = $request->file('path_gambar')->store('gambar_akun', 'public');
            $akun->path_gambar = $path;
        }

        $akun->save();

        // (MODIFIKASI) Redirect ke route yang benar
        return redirect()->route($this->getRolePrefix() . '.akun.index')
            ->with('success', 'Data akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $akun)
    {
        if (Auth::user()->id == $akun->id) {
            // (MODIFIKASI) Redirect ke route yang benar
            return redirect()->route($this->getRolePrefix() . '.akun.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // (BARU) Cek relasi ke transaksi
        // Asumsi Model User punya relasi `hasMany('Transaksi', 'id_pengguna')`
        if ($akun->transaksis()->exists()) {
            return redirect()->route($this->getRolePrefix() . '.akun.index')
                ->with('error', 'Akun tidak bisa dihapus karena memiliki riwayat transaksi.');
        }

        if ($akun->path_gambar) {
            Storage::disk('public')->delete($akun->path_gambar);
        }

        $akun->delete();

        // (MODIFIKASI) Redirect ke route yang benar
        return redirect()->route($this->getRolePrefix() . '.akun.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
