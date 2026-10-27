<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ]);

        // 2. Cari user berdasarkan username ATAU email
        $user = User::where('username', $request->login_id)
                    ->orWhere('email', $request->login_id)
                    ->first();

        // 3. Jika user tidak ditemukan
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'pesan' => 'Email atau username tidak ditemukan.'
            ], 401);
        }

        // 4. Cek apakah password-nya cocok
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'pesan' => 'Email/Username atau password salah!'
            ], 401);
        }

        // 5. CEK STATUS BLACKLIST DI SINI (Setelah password benar)
        if (isset($user->status_akun) && $user->status_akun == 'Blacklist') {
            return response()->json([
                'status' => 'error',
                'pesan' => 'Akun Anda telah diblacklist oleh Admin. Silakan hubungi pusat bantuan.'
            ], 403);
        }

        // 6. Jika lolos semua, buat Sanctum API Token
        $token = $user->createToken('auth_token')->plainTextToken;

        // 7. Kirim response sukses ke Client
        return response()->json([
            'status' => 'success',
            'pesan'  => 'Login berhasil!',
            'token'   => $token,
            'user'    => [
                'id'           => $user->id,
                'role_id'      => $user->role_id,
                'username'     => $user->username,
                'nama_lengkap' => $user->nama_lengkap,
                'email'        => $user->email,
                'foto_profil'  => $user->foto_profil,
            ]
        ], 200);
    }
}