@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 mb-4 bg-white">
    <div class="card-body d-flex align-items-center">
        <!-- Foto Profil -->
        <div class="me-4">
            @if(!empty(session('user_data')['foto_profil']))
                <img src="{{ env('API_BASE_URL_ASSET', 'http://127.0.0.1:8000') . '/' . session('user_data')['foto_profil'] }}" 
                     alt="Foto Profil" class="rounded-circle shadow-sm" width="90" height="90" style="object-fit: cover;">
            @else
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 90px; height: 90px; font-size: 35px;">
                    {{ substr(session('user_data')['nama_lengkap'] ?? 'U', 0, 1) }}
                </div>
            @endif
        </div>

        <!-- Nama dan Level Pengguna -->
        <div>
            <h4 class="fw-bold mb-1 text-dark">{{ session('user_data')['nama_lengkap'] ?? 'Pengguna' }}</h4>
            <p class="text-muted mb-2">Email: {{ session('user_data')['email'] ?? '-' }}</p>
            <div>
                <!-- Menampilkan Level / Role Pengguna -->
                <span class="badge bg-success px-3 py-2">
                    Level: 
                    @php $roleId = session('user_data')['role_id'] ?? 1; @endphp
                    @if($roleId == 1) Admin 
                    @elseif($roleId == 2) Petugas 
                    @elseif($roleId == 3) Inspector 
                    @else Penyewa 
                    @endif
                </span>
            </div>
        </div>

        <!-- Tombol Menuju Pengaturan Profil -->
        <div class="ms-auto">
            <a href="{{ route('profil.edit') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-gear-fill"></i> Pengaturan Profil
            </a>
        </div>
    </div>
</div>
    <div class="p-5 mb-4 bg-success text-white rounded-3 shadow-lg border-bottom border-light border-4">
        <div class="container-fluid py-3">
            <span class="badge bg-light text-success mb-2 px-3 py-2 text-uppercase fw-bold tracking-wider">Level 4 • Penyewa / Customer</span>
            <h1 class="display-5 fw-bold">Selamat Datang di Voya-004 Rental</h1>
            <p class="col-md-8 fs-5 text-light opacity-75">Temukan mobil atau motor terbaik untuk perjalanan Anda dengan harga sewa terjangkau dan proses pemesanan yang cepat.</p>
        </div>
    </div>

    <!-- Quick Info Banner -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card bg-white border-0 shadow-sm border-start border-success border-4 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle p-3 me-3"><i class="fas fa-car fa-2x"></i></div>
                    <div>
                        <h6 class="text-muted text-uppercase fs-7 fw-bold mb-1">Pilihan Kendaraan</h6>
                        <h4 class="fw-bold text-dark mb-0">14+ Unit Siap Disewa</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-white border-0 shadow-sm border-start border-primary border-4 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle p-3 me-3"><i class="fas fa-history fa-2x"></i></div>
                    <div>
                        <h6 class="text-muted text-uppercase fs-7 fw-bold mb-1">Riwayat Sewa Anda</h6>
                        <h4 class="fw-bold text-dark mb-0">0 Transaksi Aktif</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Actions -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-success text-white rounded p-3 d-inline-block mb-3"><i class="fas fa-caravan fa-2x"></i></div>
                        <h4 class="fw-bold">Jelajahi Katalog Kendaraan</h4>
                        <p class="text-muted">Lihat daftar lengkap mobil keluarga, city car, hingga motor matic beserta harga sewa per hari.</p>
                    </div>
                    <a href="{{ route('penyewa.katalog') }}" class="btn btn-success fw-semibold mt-3 py-2">Buka Katalog Kendaraan</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-primary text-white rounded p-3 d-inline-block mb-3"><i class="fas fa-receipt fa-2x"></i></div>
                        <h4 class="fw-bold">Riwayat & Status Sewa</h4>
                        <p class="text-muted">Pantau status pesanan sewa Anda, jadwal pengambilan kunci, serta riwayat tagihan.</p>
                    </div>
                    <a href="{{ route('penyewa.riwayat') }}" class="btn btn-outline-primary fw-semibold mt-3 py-2">Lihat Riwayat Sewa <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection