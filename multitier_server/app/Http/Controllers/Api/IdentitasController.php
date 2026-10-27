<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IdentitasController extends Controller
{
    public function index()
    {
        return response()->json([
            'nim' => '25.K3.0004',
            'nama' => 'Thalia Chelsy Vivian',
            'foto' => url('uploads/profil/1792434772_pas_foto_3x4.jpg'), // Sesuaikan jika nanti ada foto asli
            'aplikasi' => 'Voya-004'
        ], 200);
    }
}
