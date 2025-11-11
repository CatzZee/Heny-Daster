<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaksi;
use App\Models\User;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel jika tidak mengikuti konvensi 'transaksis'.
     */
    protected $table = 'transaksis';

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     * Ini HARUS cocok dengan migrasi Anda.
     */
    protected $fillable = [
        'id_pengguna',
        'nama_pembeli', // <-- (BARU)
        'kode_transaksi',
        'waktu_transaksi',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'metode_pembayaran',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'waktu_transaksi' => 'datetime',
        'total_harga' => 'decimal:2',
        'jumlah_bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    /**
     * Relasi: Satu transaksi dimiliki oleh satu Pengguna (Kasir/Admin).
     */
    public function pengguna()
    {
        // Asumsi model User Anda ada di App\Models\User
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    /**
     * Relasi: Satu transaksi memiliki BANYAK detail.
     */
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
