<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate_Http_Request;
use Illuminate\Support\Facades\Auth; // # ALUR 1: Import 'Auth' untuk cek user
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * # ALUR 2: Ini adalah parameter ajaib yang disebut "variadic parameter".
     * # '...$roles' akan menangkap semua parameter yang Anda kirim dari rute.
     * # Contoh: middleware('role:admin,pemilik')
     * #         maka $roles akan menjadi array ['admin', 'pemilik']
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // # ALUR 3: Dapatkan data user yang SEDANG LOGIN.
        // # Kita tidak perlu 'if (Auth::check())' di sini,
        // # karena kita akan pastikan middleware 'auth' dijalankan LEBIH DULU.
        // # Jadi, di titik ini, kita JAMIN user sudah login.
        $user = Auth::user();

        // # ALUR 4: Kita periksa setiap role yang diizinkan untuk rute ini.
        foreach ($roles as $role) {
            
            // # ALUR 5: Bandingkan role user (dari database, misal: 'admin')
            // # dengan role yang diizinkan (dari $roles, misal: 'admin')
            if ($user->role == $role) {
                
                // # ALUR 6: DITEMUKAN! Role-nya cocok.
                // # '$next($request)' berarti "izinkan request ini
                // # untuk lanjut ke tujuan berikutnya" (bisa middleware lain atau controller).
                return $next($request);
            }
        }

        // # ALUR 7: GAGAL.
        // # Jika 'foreach' selesai dan tidak ada 'return' yang dieksekusi,
        // # artinya user tidak punya role yang cocok.
        // # Kita paksa tampilkan halaman error 403 (Forbidden/Terlarang).
        // # Ini PENTING untuk keamanan.
        abort(403, 'AKSES DITOLAK.');
    }
}