<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InspeksiKendaraan;
use App\Models\Kendaraan;

class InspectorController extends Controller
{
    // 1. Ambil daftar kendaraan untuk diinspeksi
    public function indexKendaraan()
    {
        $kendaraans = Kendaraan::all();
        return response()->json([
            'status' => 'success',
            'data' => $kendaraans
        ], 200);
    }

    // 2. Simpan hasil pemeriksaan fisik (Checklist & Status Teknis)
    public function storeInspeksi(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:t004_kendaraan,id',
            'tahapan' => 'required|in:Pre-Rental,Post-Rental,Perawatan Rutin',
            'status_teknis' => 'required|in:Layak Jalan,Perlu Perbaikan,Dalam Perawatan',
            'catatan_inspector' => 'required|string' // Validasi agar inspector wajib memberikan catatan fisik
        ]);

        // Simpan data inspeksi
        $inspeksi = InspeksiKendaraan::create([
            'kendaraan_id' => $request->kendaraan_id,
            'inspector_id' => $request->user()->id, // Mengambil ID dari user yang sedang login
            'tahapan' => $request->tahapan,
            'kondisi_rem' => $request->kondisi_rem ?? true,
            'kondisi_ban' => $request->kondisi_ban ?? true,
            'kondisi_bodi' => $request->kondisi_bodi ?? true,
            'kondisi_mesin' => $request->kondisi_mesin ?? true,
            'status_teknis' => $request->status_teknis,
            'catatan_inspector' => $request->catatan_inspector,
        ]);

        // Perbarui status teknis pada tabel kendaraan utama
        $kendaraan = Kendaraan::find($request->kendaraan_id);
        if ($kendaraan) {
            $kendaraan->update([
                'kondisi_teknis' => $request->status_teknis
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pemeriksaan fisik dan status teknis kendaraan berhasil disimpan.',
            'data' => $inspeksi
        ], 201);
    }


    public function getLaporan(Request $request)
    {
        // Ambil data riwayat inspeksi, urutkan dari yang terbaru
        $laporans = InspeksiKendaraan::with(['kendaraan', 'inspector'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $laporans
        ], 200);
    }
}
