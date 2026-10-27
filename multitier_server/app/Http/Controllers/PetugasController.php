<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiSewa;
use Carbon\Carbon;

class PetugasController extends Controller
{
    // Menyetujui atau menolak transaksi sewa
    public function updateStatus(Request $request, $id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Selesai'
        ]);

        $transaksi->update([
            'status' => $request->status,
            'catatan_operasional' => $request->catatan_operasional ?? null
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status transaksi berhasil diperbarui oleh petugas.',
            'data' => $transaksi
        ], 200);
    }

    public function getTransaksi()
    {
        $transaksi = TransaksiSewa::with(['penyewa', 'kendaraan'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $transaksi
        ], 200);
    }

    public function serahTerima(Request $request, $id)
    {
        $transaksi = TransaksiSewa::find($id);
        if (!$transaksi) {
            return response()->json(['status' => 'error', 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        $aksi = $request->aksi;

        if ($aksi == 'check_out') {
            $transaksi->update([
                'status' => 'Sedang Disewa',
                'tgl_aktual_keluar' => Carbon::now(),
            ]);
            $pesan = 'Check-Out berhasil diproses. Kendaraan telah diserahkan kepada penyewa.';
        }elseif ($aksi == 'check_in') {
            $aktualKembali = Carbon::now();
            $rencanaKembali = Carbon::parse($transaksi->tgl_rencana_kembali);
            
            $denda = 0;
            
            // Cek jika waktu aktual melewati tanggal rencana kembali
            if ($aktualKembali->gt($rencanaKembali)) {
                // Hitung selisih hari keterlambatan
                $selisihHari = $aktualKembali->diffInDays($rencanaKembali);
                
                // Tentukan tarif denda per hari (Contoh: Rp 50.000 / hari)
                $tarifDendaPerHari = 50000; 
                $denda = max(1, $selisihHari) * $tarifDendaPerHari;
            }

            // Perbarui data transaksi
            $transaksi->update([
                'status' => 'Selesai',
                'tgl_aktual_kembali' => $aktualKembali,
                'denda' => $denda,
                'total_biaya' => $transaksi->total_biaya + $denda // Total biaya awal + denda
            ]);

            $pesan = 'Check-In berhasil. Kendaraan kembali. Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.');
        } else {
            return response()->json(['status' => 'error', 'message' => 'Aksi tidak valid.'], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $pesan,
            'data' => $transaksi
        ], 200);
    }
    public function detailTransaksi($id)
    {
        $transaksi = TransaksiSewa::with(['penyewa', 'kendaraan'])->find($id);

        if (!$transaksi) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaksi
        ], 200);
    }
}