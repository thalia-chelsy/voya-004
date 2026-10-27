<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'login_id' => 'required',
        'password' => 'required'
    ]);

    // Cari user berdasarkan email atau username
    $user = \App\Models\User::where('email', $request->login_id)
                ->orWhere('username', $request->login_id)
                ->first();

    // Cek apakah user ada dan password-nya cocok
    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'pesan' => 'Kredensial login salah.'
        ], 401);
    }

    // === TAMBAHKAN PENGECEKAN BLACKLIST DI SINI ===
    if (isset($user->status_akun) && $user->status_akun == 'Blacklist') {
        return response()->json([
            'status' => 'error',
            'pesan' => 'Akun Anda telah diblacklist oleh Admin dan tidak dapat mengakses sistem.'
        ], 403); // 403 Forbidden
    }
    // =============================================

    // Jika aman, buat token Sanctum
    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json([
        'status' => 'success',
        'token' => $token,
        'user' => $user
    ], 200);
}
}