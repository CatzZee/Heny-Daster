<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id(); // ID_Transaksi

            // ID_Pengguna (FK)
            $table->foreignId('id_pengguna')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('kode_transaksi')->unique(); // Kode_Transaksi
            $table->dateTime('waktu_transaksi')->default(now()); // Waktu_Transaksi
            $table->decimal('total_harga', 10, 2); // Total_Harga
            $table->decimal('jumlah_bayar', 10, 2); // Jumlah_Bayar
            $table->decimal('kembalian', 10, 2); // Kembalian
            $table->string('metode_pembayaran'); // Metode_Pembayaran

            // ERD Anda tidak punya timestamps di sini, tapi ini best practice
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
