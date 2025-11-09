<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('transaksis', function (Blueprint $table) {
        $table->string('nama_pembeli')->after('id_pengguna')->nullable(); // Tambahkan ini
    });
}

public function down(): void
{
    Schema::table('transaksis', function (Blueprint $table) {
        $table->dropColumn('nama_pembeli'); // Tambahkan ini
    });
}
};
