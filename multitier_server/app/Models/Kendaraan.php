<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kendaraan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't004_kendaraan'; 
    protected $guarded = ['id'];

    protected $fillable = [
        'nopol',
        'nama_model',
        'merek',
        'kategori',
        'tahun',
        'warna',
        'deskripsi',
        'harga_sewa_per_hari',
        'foto_kendaraan',
        'kondisi_teknis',
        'status_ketersediaan',
        'is_aktif',
    ];
}
