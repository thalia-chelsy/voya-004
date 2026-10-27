<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanApiController extends Controller
{
    // Menampilkan daftar kendaraan (Pencarian, Filter, & Pagination)
    public function index(Request $request)
    {
        // dd($request->all());
        $query = Kendaraan::query();

        if ($request->filled('cari')) {
            $cari = $request->input('cari');
            
            $query->where(function($q) use ($cari) {
                $q->where('merek', 'like', "%{$cari}%")
                ->orWhere('nama_model', 'like', "%{$cari}%")
                ->orWhere('nopol', 'like', "%{$cari}%");
            });
        }

        $kendaraan = $query->get(); 
        return response()->json([
            'pesan' => 'Data kendaraan berhasil diambil',
            'data' => $kendaraan
        ], 200);
    }

    // Mengambil detail satu kendaraan
    public function show($id)
    {
        $kendaraan = Kendaraan::find($id);
        
        if (!$kendaraan) {
            return response()->json(['pesan' => 'Kendaraan tidak ditemukan'], 404);
        }

        return response()->json([
            'pesan' => 'Detail kendaraan',
            'data' => $kendaraan
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return response()->json(['pesan' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nopol' => 'required|string|max:15|unique:t004_kendaraan,nopol,' . $id,
            'nama_model' => 'required|string|max:100',
            'merek' => 'required|string|max:50',
            'kategori' => 'required|string|max:50',
            'tahun' => 'required|integer',
            'warna' => 'required|string|max:30',
            'harga_sewa_per_hari' => 'required|numeric',
            'status_ketersediaan' => 'required|in:Tersedia,Pipesan,Disewa,Tidak Tersedia',
            'kondisi_teknis' => 'required|in:Layak Digunakan,Perlu Pemeriksaan,Dalam Perawatan,Tidak Layak Jalan',
        ]);

        $kendaraan->update($validated);

        return response()->json([
            'pesan' => 'Kendaraan berhasil diperbarui',
            'data' => $kendaraan
        ], 200);
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return response()->json(['pesan' => 'Data tidak ditemukan'], 404);
        }

        $kendaraan->delete();

        return response()->json([
            'pesan' => 'Kendaraan berhasil dihapus'
        ], 200);
    }

    public function store(Request $request)
{
    // Validasi data input
    $validated = $request->validate([
        'nopol' => 'required|string|max:15|unique:t004_kendaraan,nopol',
        'nama_model' => 'required|string|max:100',
        'merek' => 'required|string|max:50',
        'kategori' => 'required|string|max:50',
        'tahun' => 'required|integer',
        'warna' => 'required|string|max:30',
        'harga_sewa_per_hari' => 'required|numeric',
        'status_ketersediaan' => 'required|in:Tersedia,Pipesan,Disewa,Tidak Tersedia',
        'kondisi_teknis' => 'required|in:Layak Digunakan,Perlu Pemeriksaan,Dalam Perawatan,Tidak Layak Jalan',
    ]);

    // Simpan ke database
    $kendaraan = \App\Models\Kendaraan::create($validated);

    return response()->json([
        'pesan' => 'Kendaraan berhasil ditambahkan',
        'data' => $kendaraan
    ], 201);
}
}