<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_produks', function (Blueprint $table) {
            $table->id(); // ID_Kategori
            $table->string('nama_kategori'); // Nama_Kategori
            // timestamps (created_at, updated_at) otomatis ada jika tidak dihapus
            // ERD Anda tidak memilikinya, tapi ini best practice
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_produks');
    }
};