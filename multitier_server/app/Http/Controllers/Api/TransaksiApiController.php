<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;

class TransaksiApiController extends Controller
{
    
    public function riwayat(Request $request)
    {
        // Ambil data transaksi berdasarkan user yang sedang memegang token aktif
        $user = $request->user();
        $riwayat = TransaksiSewa::where('penyewa_id', $user->id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $riwayat
        ], 200);
    }
    
}