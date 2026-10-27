<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        try {
            $response = Http::withToken(session('api_token'))
                ->get(env('API_BASE_URL') . '/admin/transaksi');

                
                // dd($response->status(), $response->json());
            $transaksis = [];
            if ($response->successful()) {
                $transaksis = $response->json()['data'] ?? [];
            }

            return view('admin.transaksi.index', compact('transaksis'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data transaksi: ' . $e->getMessage());
        }
    }

    public function pengaduan()
    {
        try {
            $response = Http::withToken(session('api_token'))
                ->get(env('API_BASE_URL') . '/admin/pengaduan'); 

            $pengaduans = [];
            if ($response->successful()) {
                $pengaduans = $response->json()['data'] ?? [];
            }

            return view('admin.transaksi.pengaduan', compact('pengaduans'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data pengaduan: ' . $e->getMessage());
        }
    }

    public function prosesTanggapi(Request $request, $id)
    {
        try {
            $token = session('token') ?? session('api_token');

            $response = Http::withToken($token)
                ->put(env('API_BASE_URL') . "/admin/pengaduan/{$id}/tanggapi", [
                    'tanggapan' => $request->tanggapan,
                    'status' => $request->status,
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Tanggapan berhasil dikirim ke penyewa.');
            }

            return redirect()->back()->with('error', 'Gagal mengirim tanggapan dari server.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function laporanInspeksi()
    {
        try {
            $token = session('token') ?? session('api_token');

            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/admin/laporan-inspeksi');

            $laporanInspeksis = [];
            if ($response->successful()) {
                $json = $response->json();
                $laporanInspeksis = $json['data'] ?? $json ?? [];
            }

            return view('admin.laporan_inspeksi', compact('laporanInspeksis'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat laporan inspeksi: ' . $e->getMessage());
        }
    }
}
