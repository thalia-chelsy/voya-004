@extends('layouts.app')

@section('content')
<div class="container">
    @php
        // Ambil data user dari session
        $user = session('user_data');
        
        // Terjemahkan role_id menjadi nama Level
        $namaLevel = '';
        if($user['role_id'] == 1) $namaLevel = 'Admin';
        elseif($user['role_id'] == 2) $namaLevel = 'Petugas';
        elseif($user['role_id'] == 3) $namaLevel = 'Inspector';
        elseif($user['role_id'] == 4) $namaLevel = 'Penyewa';
        
        // Siapkan foto profil (pakai default kalau di database kosong)
        $fotoProfil = !empty($user['foto']) ? $user['foto'] : asset('uploads/profil/default.jpg');
    @endphp

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Dashboard Voya-004</h4>
                </div>
                <div class="card-body text-center">
                    
                    <!-- Nampilin Foto Profil -->
                    <img src="{{ $fotoProfil }}" alt="Foto Profil" class="rounded-circle mb-3 border" style="width: 150px; height: 150px; object-fit: cover;">
                    
                    <!-- Nampilin Nama & Username -->
                    <h3 class="fw-bold">{{ $user['nama_lengkap'] }}</h3>
                    <p class="text-muted">Username: {{ $user['username'] ?? $user['email'] }}</p>
                    
                    <!-- Nampilin Level Role -->
                    <span class="badge bg-success fs-5 p-2">
                        Level Akses: {{ $namaLevel }}
                    </span>

                    <hr class="mt-4">
                    
                    <p class="mb-0">
                        Selamat datang di sistem manajemen rental kendaraan! Gunakan menu di atas untuk mengelola data sesuai dengan hak akses Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection