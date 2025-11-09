<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaksi;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi 1-to-M: Satu Pengguna (User) bisa melakukan banyak Transaksi.
     */
    public function transaksis()
    {
        // 'id_pengguna' adalah foreign key di tabel 'transaksis'
        return $this->hasMany(Transaksi::class, 'id_pengguna');
    }
}