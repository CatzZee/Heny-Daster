<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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
        // [MODIFIKASI] Cek apakah user sudah login
        if (Auth::check()) {
            // Jika sudah, ambil data user
            $user = Auth::user();

            // [MODIFIKASI] Langsung redirect berdasarkan role
            // Logika ini disalin dari method store() Anda
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

        // Jika user BELUM login, baru tampilkan halaman login
        return view('auth.login');
    }

    /**
     * Menangani percobaan autentikasi.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Ambil data yang sudah divalidasi
        $credentials = $request->validated();

        // 2. Cek nilai checkbox 'remember'
        $remember = $request->boolean('remember');

        // 3. Coba lakukan login
        if (Auth::attempt(
            ['nama' => $credentials['nama'], 'password' => $credentials['password']],
            $remember
        )) {

            // 4. Regenerasi session
            $request->session()->regenerate();

            // 5. Cek role user dan arahkan
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

        // 6. Jika login gagal
        return back()->withErrors([
            'nama' => 'Nama atau password yang Anda masukkan salah.',
        ])->onlyInput('nama');
    }

    /**
     * Menangani proses logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}