<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input tanggal sewa
        $request->validate([
            'kendaraan_id' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_rencana_kembali' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        try {
            // Mengirim data pengajuan sewa ke Server API menggunakan token session penyewa
            $response = Http::withToken(session('api_token'))
                ->post(env('API_BASE_URL') . '/transaksi', [
                    'kendaraan_id' => $request->kendaraan_id,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_rencana_kembali' => $request->tgl_rencana_kembali,
                ]);

                //dd($response->status(), $response->json());
            if ($response->successful()) {
                return back()->with('success', 'Berhasil mengajukan penyewaan kendaraan!');
            }

            // Ambil pesan error dari API server jika gagal
            $pesanError = $response->json()['pesan'] ?? 'Gagal mengajukan penyewaan.';
            return back()->with('error', $pesanError);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke server: ' . $e->getMessage());
        }
    }

    public function indexPetugas()
    {
        try {
            // Ambil data melalui API dari project Server
            $response = Http::withToken(session('api_token'))
                ->get(env('API_BASE_URL') . '/petugas/transaksi'); // atau endpoint yang sesuai di server

            $transaksis = [];
            if ($response->successful()) {
                $transaksis = $response->json()['data'] ?? [];
            }

            return view('petugas.transaksi.petugas_index', compact('transaksis'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data transaksi: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // Kirim request PUT ke API Server
            $response = Http::withToken(session('api_token'))
                ->put(env('API_BASE_URL') . '/petugas/transaksi/' . $id . '/status', [
                    'status' => $request->status,
                    'catatan_operasional' => $request->catatan_operasional ?? null
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui status dari server.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexSerahTerima()
    {
        try {
            $response = Http::withToken(session('api_token'))
                ->get(env('API_BASE_URL') . '/petugas/transaksi');

            $transaksis = [];
            if ($response->successful()) {
                $json = $response->json();
                $allData = $json['data'] ?? $json ?? [];
                
                // Filter hanya transaksi yang butuh tindakan serah terima
                $transaksis = array_filter($allData, function($t) {
                    return in_array($t['status'] ?? '', ['Disetujui', 'Sedang Disewa']);
                });
            }

            return view('petugas.transaksi.serah_terima_index', compact('transaksis'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data serah terima: ' . $e->getMessage());
        }
    }

    public function formSerahTerima($id)
    {
        try {
            $response = Http::withToken(session('api_token'))
                ->get(env('API_BASE_URL') . '/petugas/transaksi/' . $id);

            $transaksi = [];
            if ($response->successful()) {
                $json = $response->json();
                // Ambil dari key 'data' jika ada, jika tidak gunakan langsung responsnya
                $transaksi = $json['data'] ?? $json ?? [];
            }

            return view('petugas.transaksi.serah_terima', compact('transaksi'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data serah terima: ' . $e->getMessage());
        }
    }

    public function prosesSerahTerima(Request $request, $id)
    {
        try {
            $response = Http::withToken(session('api_token'))
                ->put(env('API_BASE_URL') . '/petugas/transaksi/' . $id . '/serah-terima', [
                    'aksi' => $request->aksi // 'check_out' atau 'check_in'
                ]);

                // dd($response->json(), $response->status());

            if ($response->successful()) {
                return redirect()->route('petugas.transaksi.petugas_index')
                    ->with('success', $response->json()['message'] ?? 'Berhasil memproses serah terima.');
            } else {
                return redirect()->back()->with('error', 'Gagal memproses dari server.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}