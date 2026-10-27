<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 't004_pengaduan';
    protected $guarded = ['id'];

    public function kendaraan() {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}