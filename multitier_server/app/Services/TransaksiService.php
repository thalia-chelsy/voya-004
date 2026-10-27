<?php

namespace App\Services;

use App\Models\Kendaraan;
use App\Models\TransaksiSewa;
use Carbon\Carbon;
use Exception;

class TransaksiService
{
    public function ajukanSewa($penyewaId, $kendaraanId, $tglMulai, $tglRencanaKembali)
    {
        $kendaraan = Kendaraan::findOrFail($kendaraanId);

        if ($kendaraan->status_ketersediaan !== 'Tersedia' || $kendaraan->kondisi_teknis !== 'Layak Digunakan') {
            throw new Exception("Kendaraan saat ini tidak dapat disewa (Tidak Tersedia / Tidak Layak Jalan).");
        }

        $mulai = Carbon::parse($tglMulai);
        $kembali = Carbon::parse($tglRencanaKembali);
        
        if ($kembali->lessThanOrEqualTo($mulai)) {
            throw new Exception("Tanggal pengembalian harus lebih dari tanggal mulai.");
        }

        $jumlahHari = $mulai->diffInDays($kembali);
        $totalBiaya = $jumlahHari * $kendaraan->harga_sewa_per_hari;

        $transaksi = TransaksiSewa::create([
            'penyewa_id'          => $penyewaId,
            'kendaraan_id'        => $kendaraanId,
            'tgl_mulai'           => $mulai->format('Y-m-d'),
            'tgl_rencana_kembali' => $kembali->format('Y-m-d'),
            'harga_sewa_per_hari' => $kendaraan->harga_sewa_per_hari,
            'jumlah_hari_sewa'    => $jumlahHari,
            'total_biaya'         => $totalBiaya,
            'status'              => 'Menunggu Konfirmasi'
        ]);

        $kendaraan->update(['status_ketersediaan' => 'Dipesan']);

        return $transaksi;
    }

    // Logika bisnis untuk mengubah status
    public function updateStatusTransaksi($id, $statusBaru)
    {
        $transaksi = TransaksiSewa::findOrFail($id);
        $kendaraan = $transaksi->kendaraan;

        // Aturan perubahan status kendaraan berdasarkan status transaksi
        if ($statusBaru == 'Disetujui') {
            $transaksi->update(['status' => 'Disetujui']);
        } elseif ($statusBaru == 'Ditolak') {
            $transaksi->update(['status' => 'Ditolak']);
            $kendaraan->update(['status_ketersediaan' => 'Tersedia']);
        } elseif ($statusBaru == 'Sedang Disewa') {
            $transaksi->update(['status' => 'Sedang Disewa']);
            $kendaraan->update(['status_ketersediaan' => 'Disewa']);
        } elseif ($statusBaru == 'Selesai') {
            $transaksi->update([
                'status' => 'Selesai',
                'tgl_kembali_aktual' => now()->format('Y-m-d')
            ]);
            $kendaraan->update(['status_ketersediaan' => 'Tersedia']);
        }

        return $transaksi;
    }
}