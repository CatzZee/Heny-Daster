<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'id_pengguna',
        'kode_transaksi',
        'waktu_transaksi',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'metode_pembayaran',
    ];

    /**
     * Relasi M-to-1: Satu Transaksi dimiliki oleh satu Pengguna (User).
     */
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    /**
     * Relasi 1-to-M: Satu Transaksi memiliki banyak DetailTransaksi.
     */
    public function detailTransaksis()
    {
        // 'id_transaksi' adalah foreign key di tabel 'detail_transaksis'
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
