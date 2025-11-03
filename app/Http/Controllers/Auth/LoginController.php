<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest; // 1. Import Request yang baru dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Menampilkan view login.
     */
    public function create()
    {
        return view('auth.login'); // Asumsi view Anda ada di resources/views/auth/login.blade.php
    }

    /**
     * Menangani percobaan autentikasi.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Ambil data yang sudah divalidasi
        $credentials = $request->validated();

        // 2. [BARU] Cek nilai checkbox 'remember'
        //    $request->boolean('remember') akan bernilai 'true' jika dicentang
        //    dan 'false' jika tidak (ini cara aman mengambil nilai checkbox)
        $remember = $request->boolean('remember');

        // 3. [MODIFIKASI] Tambahkan $remember sebagai parameter kedua
        if (Auth::attempt(
            ['nama' => $credentials['nama'], 'password' => $credentials['password']],
            $remember // <-- Ini dia kuncinya
        )) {

            // 4. Regenerasi session
            $request->session()->regenerate();

            // 5. Cek role user dan arahkan (logika ini tetap sama)
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'kasir':
                    return redirect()->intended('/kasir/dashboard');
                case 'pemilik':
                    return redirect()->intended('/pemilik/dashboard');
                default:
                    return redirect()->intended('/dashboard');
            }
        }

        // 6. Jika login gagal (logika ini tetap sama)
        return back()->withErrors([
            'nama' => 'Nama atau password yang Anda masukkan salah.',
        ])->onlyInput('nama');
    }

    /**
     * Menangani proses logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $user = Auth::user();

        // 2. Cek token SEBELUM logout
        $tokenSebelum = $user->remember_token;

        // 3. Panggil fungsi logout Bawaan
        Auth::logout();

        // 4. Ambil data user 'fresh' dari database SETELAH logout
        $userFresh = \App\Models\User::find($userId);
        $tokenSesudah = $userFresh->remember_token;

        // 5. Hentikan eksekusi dan tunjukkan hasilnya
        dd(
            '--- ANALISIS LOGOUT ---',
            'User:',
            $userFresh->nama,
            'Token SEBELUM Logout:',
            $tokenSebelum,
            'Token SESUDAH Logout:',
            $tokenSesudah,
            'Status Harusnya:',
            'NULL',
            'Status Test:',
            ($tokenSesudah === null) ? 'BERHASIL' : 'GAGAL'
        );
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
