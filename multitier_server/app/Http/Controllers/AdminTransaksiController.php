<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiSewa; // Sesuaikan dengan model transaksi Anda (misal prefix t004_)
use Illuminate\Support\Facades\DB;

class AdminTransaksiController extends Controller
{
    // Menampilkan seluruh daftar transaksi dan laporan inspeksi
    public function index()
    {
        $transaksi = \App\Models\TransaksiSewa::with(['penyewa', 'kendaraan'])->latest()->get(); 

        return response()->json([
            'status' => 'success',
            'data' => $transaksi
        ], 200);
    }

    public function pengaduan()
    {
        // Ambil langsung dari model Pengaduan lengkap dengan relasinya
        $pengaduans = \App\Models\Pengaduan::with(['penyewa', 'kendaraan'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pengaduans
        ], 200);
    }
}