<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class PenyewaController extends Controller
{
    public function katalog(Request $request)
    {
        try {
            $token = session('api_token');
            
            // Tangkap keyword pencarian dari input form (name="cari")
            $keyword = $request->get('cari');

            // Kirim parameter 'cari' ke Server API menggunakan query string
            $response = Http::withToken($token)->get(env('API_BASE_URL') . '/kendaraan', [
                'cari' => $keyword
            ]);

            $kendaraanData = [];
            if ($response->successful()) {
                $kendaraanData = $response->json()['data'] ?? [];
            }

            // Paginasi manual untuk array data dari API
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 6;
            $currentItems = array_slice($kendaraanData, ($currentPage - 1) * $perPage, $perPage);
            
            $kendaraan = new LengthAwarePaginator(
                $currentItems, 
                count($kendaraanData), 
                $perPage, 
                $currentPage, 
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('penyewa.katalog', compact('kendaraan'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat katalog: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        try {
            $token = session('token') ?? session('api_token');

            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/penyewa/riwayat-sewa');

            // Cek status dan isi data yang dikirim oleh server di sini
            // dd($response->status(), $response->json());

            $riwayats = [];
            if ($response->successful()) {
                $riwayats = $response->json()['data'] ?? [];
            }

            return view('penyewa.riwayat', compact('riwayats'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat riwayat sewa: ' . $e->getMessage());
        }
    }
    public function createPengaduan()
    {
        try {
            $token = session('token') ?? session('api_token');

            // Ambil data kendaraan dari API server untuk pilihan di form
            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/inspector/kendaraan'); // atau endpoint katalog kendaraan

            $kendaraans = [];
            if ($response->successful()) {
                $json = $response->json();
                $kendaraans = $json['data'] ?? $json ?? [];
            }

            return view('penyewa.pengaduan', compact('kendaraans'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data kendaraan: ' . $e->getMessage());
        }
    }
    public function storePengaduan(Request $request)
    {
        try {
            $token = session('token') ?? session('api_token');

            $response = Http::withToken($token)
                ->post(env('API_BASE_URL') . '/penyewa/pengaduan', [
                    'kendaraan_id' => $request->kendaraan_id,
                    'isi_pengaduan' => $request->isi_pengaduan,
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Pengaduan berhasil dikirim! Tim kami akan segera meninjau.');
            }

            return redirect()->back()->with('error', 'Gagal mengirim pengaduan dari server.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}