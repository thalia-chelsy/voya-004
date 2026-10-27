<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Menampilkan daftar seluruh user
    public function index()
    {
        $users = User::all(); 

        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    // Fungsi update yang benar dan digunakan oleh rute API
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validasi input status dari client
        $request->validate([
            'status_akun' => 'required|in:Aktif,Blacklist',
        ]);

        // Update status akun & role jika dikirim
        $user->update([
            'role_id' => $request->role_id ?? $user->role_id,
            'status_akun' => $request->status_akun,
        ]);

        return response()->json([
            'status' => 'success',
            'pesan' => 'Status pengguna berhasil diperbarui menjadi ' . $request->status_akun,
            'data' => $user
        ], 200);
    }

    public function showProfile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:t004_users,email,' . $user->id,
            'password_lama' => 'nullable|required_with:password_baru',
            'password_baru' => 'nullable|min:6',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;

        if ($request->filled('password_lama')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password lama yang Anda masukkan salah.'
                ], 422);
            }
            $user->password = Hash::make($request->password_baru);
        }

        
    if ($request->hasFile('foto_profil')) {
        $file = $request->file('foto_profil');
        
        $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        
        $destinationPath = public_path('uploads');

        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        
        if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
            @unlink(public_path($user->foto_profil));
        }

        
        if (move_uploaded_file($file->getPathname(), $destinationPath . DIRECTORY_SEPARATOR . $filename)) {
            
            $user->foto_profil = 'uploads/' . $filename;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunggah foto karena pembatasan sistem (OneDrive).'
            ], 500);
        }
    }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui.',
            'data' => $user
        ], 200);
    }

}