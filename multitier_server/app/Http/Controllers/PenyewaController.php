<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function riwayatSewa(Request $request)
    {
        // Gunakan model TransaksiSewa dan pastikan menyesuaikan kolom user_id
        $riwayat = \App\Models\TransaksiSewa::with('kendaraan', 'penyewa')
                    ->where('penyewa_id', $request->user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        // dd( $riwayat);

        return response()->json([
            'status' => 'success',
            'data' => $riwayat
        ], 200);
    }
}
