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
    <div class="p-5 mb-4 bg-primary text-white rounded-3 shadow-lg border-bottom border-warning border-4">
        <div class="container-fluid py-3">
            <span class="badge bg-warning text-dark mb-2 px-3 py-2 text-uppercase fw-bold tracking-wider">Level 2 • Petugas Operasional</span>
            <h1 class="display-5 fw-bold">Dashboard Petugas Voya-004</h1>
            <p class="col-md-8 fs-5 text-light opacity-75">Pusat kendali transaksi sewa harian, verifikasi peminjaman, dan penyerahan kunci kendaraan kepada penyewa.</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm border-start border-primary border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Persetujuan Masuk</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-file-signature text-primary me-2"></i> 3 Permintaan</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm border-start border-warning border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Serah Terima Hari Ini</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-key text-warning me-2"></i> 2 Unit</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm border-start border-success border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Armada Siap Jalan</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-check text-success me-2"></i> 14 Unit</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcuts -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-primary text-white rounded p-3 d-inline-block mb-3"><i class="fas fa-clipboard-list fa-2x"></i></div>
                        <h4 class="fw-bold">Katalog & Stok</h4>
                        <p class="text-muted">Periksa ketersediaan unit kendaraan secara *real-time* untuk calon penyewa.</p>
                    </div>
                    <a href="{{ route('kendaraan.index') }}" class="btn btn-outline-primary fw-semibold mt-3">Buka Katalog <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-warning text-dark rounded p-3 d-inline-block mb-3"><i class="fas fa-handshake fa-2x"></i></div>
                        <h4 class="fw-bold">Persetujuan Sewa</h4>
                        <p class="text-muted">Validasi formulir pesanan dan setujui transaksi penyewaan kendaraan.</p>
                    </div>
                    <a href="{{ route('petugas.transaksi.petugas_index') }}" class="btn btn-outline-warning text-dark fw-semibold mt-3">Proses Sewa <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-success text-white rounded p-3 d-inline-block mb-3"><i class="fas fa-car-crash fa-2x"></i></div>
                        <h4 class="fw-bold">Serah Terima & Kembali</h4>
                        <p class="text-muted">Catat kondisi odometer dan serah terima kunci saat serah terima unit.</p>
                    </div>
                    <a href="{{ route('petugas.transaksi.serah_terima') }}" class="btn btn-outline-success fw-semibold mt-3">Kelola Transaksi <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection