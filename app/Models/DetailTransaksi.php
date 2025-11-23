<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel jika tidak mengikuti konvensi.
     */
    protected $table = 'detail_transaksis';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'harga_saat_transaksi',
    ];

    /**
     * Migrasi Anda memiliki timestamps(), jadi kita BIARKAN
     * $timestamps = true (default).
     * (Jika migrasi Anda TIDAK punya timestamps(), 
     * tambahkan: public $timestamps = false;)
     */

    /**
     * Relasi: Satu detail transaksi dimiliki oleh satu Transaksi.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    /**
     * Relasi: Satu detail transaksi merujuk ke satu Produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
