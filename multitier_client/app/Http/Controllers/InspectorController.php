<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InspectorController extends Controller
{
    // 1. Menampilkan daftar kendaraan untuk diinspeksi
    public function index()
    {
        try {

        $token = session('token') ?? session('api_token');
        
            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/inspector/kendaraan');
// dd($response->json());
                
            $kendaraans = [];
            if ($response->successful()) {
                $json = $response->json();
                $kendaraans = $json['data'] ?? $json ?? [];
                session(['user' => $user_data ?? []]); // Simpan data user ke session jika ada
            }else {
                // Jika tokenexpired/unauthenticated, arahkan ke login atau tampilkan pesan
                if ($response->status() == 401) {
                    return redirect()->route('login')->with('error', 'Sesi Anda telah habis, silakan login ulang.');
                }
            }

            return view('inspector.index', compact('kendaraans'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data kendaraan: ' . $e->getMessage());
        }
    }

    // 2. Menyimpan form hasil inspeksi fisik ke API Server
    public function store(Request $request)
    {
        try {
            $response = Http::withToken(session('api_token'))
                ->post(env('API_BASE_URL') . '/inspector/inspeksi', [
                    'kendaraan_id' => $request->kendaraan_id,
                    'tahapan' => $request->tahapan,
                    'kondisi_rem' => $request->has('kondisi_rem') ? 1 : 0,
                    'kondisi_ban' => $request->has('kondisi_ban') ? 1 : 0,
                    'kondisi_bodi' => $request->has('kondisi_bodi') ? 1 : 0,
                    'kondisi_mesin' => $request->has('kondisi_mesin') ? 1 : 0,
                    'status_teknis' => $request->status_teknis,
                    'catatan_inspector' => $request->catatan_inspector,
                ]);

            if ($response->successful()) {
                return redirect()->route('inspector.index')
                    ->with('success', 'Pemeriksaan fisik dan status teknis berhasil disimpan.');
            } else {
                $errorMsg = $response->json()['message'] ?? 'Gagal menyimpan pemeriksaan dari server.';
                return redirect()->back()->with('error', $errorMsg)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function laporan()
    {
        try {
            $token = session('token') ?? session('api_token');

            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/inspector/laporan');

            $laporans = [];
            if ($response->successful()) {
                $json = $response->json();
                $laporans = $json['data'] ?? $json ?? [];
            }

            return view('inspector.laporan', compact('laporans'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat laporan: ' . $e->getMessage());
        }
    }
}
