<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // Nampilin form login (Blade)
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file login.blade.php udah kamu pindah ke sini ya
    }

    // Proses kirim data login ke Server API
    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required'
        ]);

        try {
            // Nembak API Login di Server
            $response = Http::post(env('API_BASE_URL') . '/login', [
                'login_id' => $request->login_id,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Simpan token dan data user ke session client
                session([
                    'api_token' => $data['token'] ?? $data['access_token'],
                    'user_data' => $data['user'] ?? $data['data'] ?? [] // Pastikan data user disimpan di sini!
                ]);


                // Ambil role_id dari struktur data user yang dikirim server
                $role = $data['user']['role_id'] ?? null;

                // Arahkan ke dashboard spesifik berdasarkan role
                if ($role == 1) {
                    return redirect()->route('admin.dashboard');
                } elseif ($role == 2) {
                    return redirect()->route('petugas.dashboard');
                } elseif ($role == 3) {
                    return redirect()->route('inspector.dashboard');
                } elseif ($role == 4) {
                    return redirect()->route('penyewa.dashboard');
                }

                return redirect('/dashboard');
            }

            // Jika server menolak (password salah, dll)
            $errorData = $response->json();
            $pesanError = $response->json()['pesan'] ?? $errorData['pesan'] ?? 'Login gagal, periksa kembali email/username dan password.';
            return back()->withInput()->with('error', $pesanError);

        } catch (\Exception $e) {
            // Jika server mati / tidak terjangkau sama sekali
            return back()->withInput()->with('error', 'Gagal terhubung ke server: ' . $e->getMessage());
        }
    }

    public function prosesLogin(Request $request)
    {
        // ... proses request login ke API Server ...

        if ($response->successful()) {
            $result = $response->json();
            
            // Simpan token dan data user ke session client
            session([
                'token' => $result['token'] ?? $result['access_token'],
                'user'  => $result['user'] ?? $result['data'] ?? [] // Pastikan data user disimpan di sini!
            ]);

            return redirect()->intended('/admin/dashboard');
        }
    }

    // Nampilin form register (Blade)
    public function showRegisterForm()
    {
        return view('auth.register'); 
    }

    // Proses kirim data registrasi ke Server API
    public function register(Request $request)
    {
        // Pada bagian validasi:
    $request->validate([
        'nama_lengkap' => 'required',
        'username' => 'required',
        'email' => 'required|email', // <-- Tambahan
        'password' => 'required|confirmed',
        'role_id' => 'required'
    ]);

    // Pada bagian Http::post:
    $response = Http::post(env('API_BASE_URL') . '/register', [
        'nama_lengkap' => $request->nama_lengkap,
        'username' => $request->username,
        'email' => $request->email, // <-- Tambahan
        'password' => $request->password,
        'password_confirmation' => $request->password_confirmation,
        'role_id' => $request->role_id,
    ]);

        if ($response->successful()) {
            $data = $response->json()['data'];
            
            // Langsung login-kan setelah sukses daftar
            session([
                'api_token' => $data['token'],
                'user_data' => $data['user']
            ]);

            return redirect('/dashboard')->with('success', 'Berhasil mendaftar dan login!');
        }

        // Kalau gagal (misal username udah dipakai)
        $pesanError = $response->json()['pesan'] ?? 'Gagal mendaftar';
        return back()->with('error', $pesanError);
    }

    public function dashboard()
    {
        try {
            $token = session('token') ?? session('api_token');

            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/user/profil');

            $user = [];
            if ($response->successful()) {
                $user = $response->json()['data'] ?? [];
                session(['user' => $user]); // Update session user
            } else {
                $user = session('user') ?? [];
            }

            return view('admin.dashboard', compact('user')); // Sesuaikan view per role
        } catch (\Exception $e) {
            $user = session('user') ?? [];
            return view('admin.dashboard', compact('user'));
        }
    }

    // Proses Logout
    public function logout()
    {
        // Nembak API Logout di Server pakai Token yang disimpen
        if (session('api_token')) {
            try {
                Http::withToken(session('api_token'))->post(env('API_BASE_URL') . '/logout');
            } catch (\Exception $e) {
                // Abaikan jika ada gangguan koneksi saat proses logout ke server
            }
        }

        // Hapus seluruh session di Client
        session()->flush();
        return redirect('/login')->with('success', 'Berhasil logout!');
    }

    public function editProfile()
    {
        try {
            $token = session('token') ?? session('api_token');

            $response = Http::withToken($token)
                ->get(env('API_BASE_URL') . '/user/profil');

            $user = [];
            if ($response->successful()) {
                $user = $response->json()['data'] ?? [];
                
                // Simpan juga ke session 'user' agar seragam dengan bagian lain
                session(['user' => $user]);
            }

            return view('auth.profil', compact('user'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat profil: ' . $e->getMessage());
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $token = session('token') ?? session('api_token');

            $http = Http::withToken($token);

            if ($request->hasFile('foto_profil')) {
                $http->attach(
                    'foto_profil', 
                    file_get_contents($request->file('foto_profil')->path()), 
                    $request->file('foto_profil')->getClientOriginalName()
                );
            }

            $response = $http->post(env('API_BASE_URL') . '/user/profil', [
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password_lama' => $request->password_lama,
                'password_baru' => $request->password_baru,
                '_method' => 'PUT',
            ]);

            $resJson = $response->json();

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Profil dan password berhasil diperbarui!');
            }

            $errorMsg = $resJson['message'] ?? 'Gagal memperbarui profil dari server.';
            return redirect()->back()->with('error', $errorMsg);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}