<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksis';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'harga_saat_transaksi',
    ];

    /**
     * Relasi M-to-1: Satu DetailTransaksi dimiliki oleh satu Transaksi.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    /**
     * Relasi M-to-1: Satu DetailTransaksi merujuk ke satu Produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}