<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminUserController extends Controller
{
    public function index()
    {
        try {
            $token = session('token') ?? session('api_token');

            // Ambil daftar semua pengguna dari API Server (sesuaikan endpoint server kamu, misal /admin/users atau /users)
            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/admin/users'); // Pastikan endpoint ini ada di server

            $users = [];
            if ($response->successful()) {
                $resData = $response->json();
                // Ambil array data pengguna dari respons server
                $users = $resData['data'] ?? $resData ?? [];
            }

            // Arahkan ke file view manajemen pengguna yang sesuai
            return view('admin.users.index', compact('users')); 

        } catch (\Exception $e) {
            $users = [];
            return view('admin.users.index', compact('users'))->with('error', 'Gagal memuat data pengguna: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::withToken(session('token') ?? session('api_token'))
                ->put(env('API_BASE_URL') . '/admin/users/' . $id, [
                    'status_akun' => $request->status_akun,
                ]);

            if ($response->successful()) {
                return back()->with('success', 'Status pengguna berhasil diperbarui.');
            }

            $errorMsg = $response->json()['pesan'] ?? $response->json()['message'] ?? 'Gagal memperbarui pengguna.';
            return back()->with('error', $errorMsg);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan koneksi: ' . $e->getMessage());
        }
    }
}