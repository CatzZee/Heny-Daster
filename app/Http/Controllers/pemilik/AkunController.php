<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; // GANTI Storage dengan File
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    private function getRolePrefix(): string
    {
        return Auth::user()->role;
    }

    public function index()
    {
        $users = User::latest()->get();
        $routePrefix = $this->getRolePrefix();
        return view('pemilik.dataAkun', compact('users', 'routePrefix'));
    }

    public function create()
    {
        return redirect()->route($this->getRolePrefix() . '.akun.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:users,nama',
            'role' => 'required|in:admin,kasir,pemilik',
            'password' => 'required|string|min:8|confirmed',
            'path_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        // LOGIKA UPLOAD (Akun)
        if ($request->hasFile('path_gambar')) {
            $file = $request->file('path_gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/gambar_akun');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file->move($destinationPath, $fileName);
            $path = 'uploads/gambar_akun/' . $fileName;
        }

        User::create([
            'nama' => $validated['nama'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'path_gambar' => $path,
        ]);

        return redirect()->route($this->getRolePrefix() . '.akun.index')
            ->with('success', 'Akun baru berhasil ditambahkan.');
    }

    public function show(User $akun)
    {
        return redirect()->route($this->getRolePrefix() . '.akun.index');
    }

    public function edit(User $akun)
    {
        return redirect()->route($this->getRolePrefix() . '.akun.index');
    }

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

        // LOGIKA UPDATE GAMBAR (Akun)
        if ($request->hasFile('path_gambar')) {
            // Hapus lama
            if ($akun->path_gambar && File::exists(public_path($akun->path_gambar))) {
                File::delete(public_path($akun->path_gambar));
            }
            
            // Upload baru
            $file = $request->file('path_gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/gambar_akun');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file->move($destinationPath, $fileName);
            $akun->path_gambar = 'uploads/gambar_akun/' . $fileName;
        }

        $akun->save();

        return redirect()->route($this->getRolePrefix() . '.akun.index')
            ->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(User $akun)
    {
        if (Auth::user()->id == $akun->id) {
            return redirect()->route($this->getRolePrefix() . '.akun.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($akun->transaksis()->exists()) {
            return redirect()->route($this->getRolePrefix() . '.akun.index')
                ->with('error', 'Akun tidak bisa dihapus karena memiliki riwayat transaksi.');
        }

        // HAPUS GAMBAR
        if ($akun->path_gambar && File::exists(public_path($akun->path_gambar))) {
            File::delete(public_path($akun->path_gambar));
        }

        $akun->delete();

        return redirect()->route($this->getRolePrefix() . '.akun.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}