<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RegisterController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware
     */
    public static function middleware(): array
    {
        return [
            new Middleware('guest'),
        ];
    }

/**
     * Proses Registrasi API
     */
    public function register(Request $request)
    {
        // Bagian Validasi
        $validator = Validator::make($request->all(), [
        'nama_lengkap' => ['required', 'string', 'max:255'],
        'username'     => ['required', 'string', 'max:255', 'unique:t004_users,username'],
        'email'        => ['required', 'string', 'email', 'max:255', 'unique:t004_users,email'], // <-- Tambahan
        'password'     => ['required', 'string', 'min:8', 'confirmed'],
        'role_id'      => ['required', 'integer'],
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'pesan'  => 'Validasi gagal, silakan periksa form Anda',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Simpan user baru dan masukkan role_id dari form
        $user = User::create([
        'nama_lengkap' => $request->nama_lengkap,
        'username'     => $request->username,
        'email'        => $request->email, // <-- Tambahan
        'password'     => Hash::make($request->password),
        'role_id'      => $request->role_id,
    ]);

        // 3. Buatkan token
        $token = $user->createToken('token_voya004')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'pesan'  => 'Registrasi berhasil',
            'data'   => [
                'user'  => $user,
                'token' => $token
            ]
        ], 201);
    }
}