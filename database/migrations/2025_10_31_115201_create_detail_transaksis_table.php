<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id(); // ID_Detail_Transaksi

            // ID_Transaksi (FK)
            $table->foreignId('id_transaksi')
                ->constrained('transaksis')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // Jika transaksi dihapus, detailnya ikut hapus

            // ID_Produk (FK)
            $table->foreignId('id_produk')
                ->constrained('produks')
                ->onUpdate('cascade')
                ->onDelete('restrict'); // Jangan hapus produk jika masih ada di detail transaksi

            $table->integer('jumlah'); // Jumlah
            $table->decimal('harga_saat_transaksi', 10, 2); // Harga_saat_transaksi

            // ERD Anda tidak punya timestamps di sini, tapi ini best practice
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
