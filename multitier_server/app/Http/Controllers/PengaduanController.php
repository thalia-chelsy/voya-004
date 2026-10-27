<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with(['user', 'kendaraan'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $pengaduans
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:t004_kendaraan,id',
            'isi_pengaduan' => 'required|string|max:1000',
        ]);

        $pengaduan = Pengaduan::create([
            'user_id' => $request->user()->id,
            'kendaraan_id' => $request->kendaraan_id,
            'isi_pengaduan' => $request->isi_pengaduan,
            'status' => 'Menunggu',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaduan berhasil dikirim ke Admin.',
            'data' => $pengaduan
        ], 201);
    }

    public function pengaduanAdmin()
    {
        // Gunakan with(['user', 'kendaraan']) agar relasinya ikut terbawa ke client
        $pengaduans = Pengaduan::with(['user', 'kendaraan'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pengaduans
        ], 200);
    }

    public function tanggapi(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required|string',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'tanggapan' => $request->tanggapan,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tanggapan pengaduan berhasil disimpan.',
            'data' => $pengaduan
        ], 200);
    }
}