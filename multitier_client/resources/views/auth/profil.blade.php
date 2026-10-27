@extends('layouts.app')
@section('title', 'Pengaturan Profil Voya-004')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Halaman Pengaturan Profil - Voya-004</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Preview Foto Profil -->
                        <div class="text-center mb-4">
                            @if(!empty($user['foto_profil']))
                                <img src="{{ env('API_BASE_URL_ASSET', 'http://127.0.0.1:8000') . '/' . $user['foto_profil'] }}" 
                                     alt="Foto Profil" class="rounded-circle img-thumbnail shadow-sm" width="130" height="130" style="object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 130px; height: 130px; font-size: 45px;">
                                    {{ substr($user['nama_lengkap'] ?? 'U', 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <!-- Upload Foto Profil -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ganti Foto Profil</label>
                            <input type="file" name="foto_profil" class="form-control" accept="image/*">
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $user['nama_lengkap'] ?? '' }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user['email'] ?? '' }}" required>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold text-secondary mb-3">Ubah Kata Sandi (Opsional)</h5>

                        <!-- Password Lama -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control" placeholder="Masukkan password lama jika ingin mengubah sandi">
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" placeholder="Masukkan password baru...">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mt-3 fw-bold">Simpan Semua Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection