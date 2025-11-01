<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'kategori_produks';

    // Kolom yang boleh diisi
    protected $fillable = ['nama_kategori'];

    /**
     * Relasi 1-to-M: Satu Kategori memiliki banyak Produk.
     */
    public function produks()
    {
        // 'id_kategori' adalah foreign key di tabel 'produks'
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
