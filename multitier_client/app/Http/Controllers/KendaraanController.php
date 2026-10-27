<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KendaraanController extends Controller
{
    // Menampilkan daftar kendaraan (Katalog)
    public function index()
    {
        try {
            // Ambil token dari session login
            $token = session('api_token');

            // Request ke API Server
            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/kendaraan');

            //dd($response->body()); // Debugging: Tampilkan response body
            if ($response->successful()) {
                $result = $response->json();
                $kendaraan = $result['data'] ?? [];
                return view('kendaraan.index', compact('kendaraan'));
            }

            return back()->with('error', 'Gagal memuat data kendaraan dari server.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan koneksi ke server.');
        }
    }

        // Menampilkan form tambah kendaraan
    public function create()
    {
        return view('kendaraan.create');
    }

    // Menyimpan data baru melalui API Server
    public function store(Request $request)
    {
        try {
            $token = session('api_token');

            // Kirim data form ke API Server menggunakan POST
            $response = Http::withToken($token)
                ->post(env('API_BASE_URL') . '/kendaraan', $request->all());

            
            if ($response->successful()) {
                return redirect()->route('kendaraan.index')->with('success', 'Kendaraan baru berhasil ditambahkan!');
            }
            // dd($response->json() ?? $response->body());
            return back()->withInput()->with('error', 'Gagal menyimpan data ke server: ' . $response->body());
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Koneksi terputus: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $token = session('api_token');
            $response = Http::withToken($token)->get(env('API_BASE_URL') . '/kendaraan/' . $id);

            if ($response->successful()) {
                $result = $response->json();
                $kendaraan = $result['data'] ?? [];
                return view('kendaraan.edit', compact('kendaraan'));
            }

            return back()->with('error', 'Gagal memuat data kendaraan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi terputus: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $token = session('api_token');
            $response = Http::withToken($token)->put(env('API_BASE_URL') . '/kendaraan/' . $id, $request->all());

            if ($response->successful()) {
                return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui!');
            }

            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Koneksi terputus: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $token = session('api_token');
            $response = Http::withToken($token)->delete(env('API_BASE_URL') . '/kendaraan/' . $id);

            if ($response->successful()) {
                return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil dihapus!');
            }

            return back()->with('error', 'Gagal menghapus data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi terputus: ' . $e->getMessage());
        }
    }
}