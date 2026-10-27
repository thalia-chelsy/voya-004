<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiSewa;

class TransaksiController extends Controller
{
    protected $transaksiService;

    // Inject Service Layer
    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    // Fungsi untuk menerima request pengajuan dari Penyewa (API)
    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:t004_kendaraan,id',
            'tgl_mulai' => 'required|date|after_or_equal:today',
            'tgl_rencana_kembali' => 'required|date|after:tgl_mulai',
        ]);

        try {
            // Panggil Service untuk memproses logika bisnis
            $transaksi = $this->transaksiService->ajukanSewa(
                Auth::id(), 
                $request->kendaraan_id, 
                $request->tgl_mulai, 
                $request->tgl_rencana_kembali
            );

            // KEMBALIKAN JSON (Bukan redirect/back)
            return response()->json([
                'status' => 'success',
                'pesan' => 'Pengajuan sewa berhasil dibuat. Menunggu konfirmasi Petugas.',
                'data' => $transaksi
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'pesan' => $e->getMessage()
            ], 400);
        }
    }

    // Menampilkan daftar transaksi untuk Petugas/Admin (API)
    public function indexPetugas()
    {
        $transaksi = \App\Models\TransaksiSewa::with(['penyewa', 'kendaraan'])->latest()->paginate(10);
        
        // KEMBALIKAN JSON (Bukan return view)
        return response()->json([
            'status' => 'success',
            'pesan' => 'Data transaksi berhasil diambil',
            'data' => $transaksi
        ], 200);
    }

    // Memperbarui status transaksi (API)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Sedang Disewa,Selesai,Dibatalkan'
        ]);

        try {
            // Panggil Service (Logika pindah ke service biar rapi)
            $transaksi = $this->transaksiService->updateStatusTransaksi($id, $request->status);

            // KEMBALIKAN JSON
            return response()->json([
                'status' => 'success',
                'pesan' => 'Status transaksi berhasil diperbarui menjadi: ' . $request->status,
                'data' => $transaksi
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'pesan' => $e->getMessage()
            ], 400);
        }
    }

    
    
}