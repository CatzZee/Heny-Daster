<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel secara eksplisit (opsional jika nama sudah 'produks').
     */
    protected $table = 'produks';

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     * Ini HARUS cocok dengan kolom di migrasi Anda (kecuali ID dan timestamps).
     */
    protected $fillable = [
        'id_kategori',  // dari $table->foreignId('id_kategori')
        'nama_produk',  // dari $table->string('nama_produk')
        'harga_produk', // dari $table->decimal('harga_produk', 10, 2)
        'stok_produk',  // dari $table->integer('stok_produk')
    ];

    /**
     * Relasi M-to-1 (belongsTo):
     * Didefinisikan oleh migrasi: $table->foreignId('id_kategori')
     * Satu Produk dimiliki oleh satu Kategori.
     */
    public function kategori()
    {
        // Parameter kedua ('id_kategori') adalah foreign key di tabel 'produks' ini
        return $this->belongsTo(KategoriProduk::class, 'id_kategori');
    }

    /**
     * Relasi 1-to-M (hasMany):
     * Relasi ke tabel 'detail_transaksis' (yang akan memiliki 'id_produk')
     * Satu Produk bisa muncul di banyak DetailTransaksi.
     */
    public function detailTransaksis()
    {
        // Parameter kedua ('id_produk') adalah foreign key di tabel 'detail_transaksis'
        return $this->hasMany(DetailTransaksi::class, 'id_produk');
    }
}
