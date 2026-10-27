<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiSewa extends Model
{
    protected $table = 't004_transaksi_sewa';
    protected $guarded = ['id'];

    // Relasi ke User menggunakan foreign key 'penyewa_id'
    public function penyewa()
    {
        return $this->belongsTo(User::class, 'penyewa_id');
    }

    // Relasi ke Kendaraan menggunakan foreign key 'kendaraan_id'
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }
}