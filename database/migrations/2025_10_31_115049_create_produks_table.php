<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id(); // ID_Produk

            // ID_Kategori (FK)
            $table->foreignId('id_kategori')
                ->constrained('kategori_produks')
                ->onUpdate('cascade')
                ->onDelete('restrict'); // atau onDelete('set null') jika diizinkan
                
            $table->string('ukuran_baju')->nullable(); // Sesuai dengan Ukuran_baju
            $table->string('path_gambar')->nullable(); // Sesuai dengan Path_Gambar
            $table->string('nama_produk'); // Nama_Produk
            $table->decimal('harga_produk', 10, 2); // Harga_produk DECIMAL(10,2)
            $table->integer('stok_produk'); // Stok_Produk
            $table->timestamps(); // created_at & update_at (seharusnya updated_at)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
