<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- Tambahkan ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin Spesifik
        User::create([
            'nama' => 'Admin Utama',
            'password' => Hash::make('admin123'), // Password: admin123
            'role' => 'admin',
        ]);

        // 2. Buat User Kasir Spesifik
        User::create([
            'nama' => 'Kasir Satu',
            'password' => Hash::make('kasir123'), // Password: kasir123
            'role' => 'kasir',
        ]);

        // 3. Buat User Pemilik Spesifik
        User::create([
            'nama' => 'Pemilik Toko',
            'password' => Hash::make('pemilik123'), // Password: pemilik123
            'role' => 'pemilik',
        ]);

        // 4. (Opsional) Buat 5 user kasir acak
        // Ini akan menggunakan factory yang kita edit tadi
        // Password mereka semua adalah 'password123'
        User::factory(2)->create();
    }
}