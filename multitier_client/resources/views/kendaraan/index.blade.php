@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold">Katalog Kendaraan Voya-004</h2>
            <p class="text-muted">Kelola dan lihat daftar kendaraan yang tersedia untuk disewa.</p>
        </div>
        <div class="col-auto">
            {{-- Tombol Tambah bisa dikondisikan sesuai role jika diperlukan --}}
            <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kendaraan
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Kendaraan</th>
                            <th>Jenis</th>
                            <th>Nomor Plat</th>
                            <th>Harga / Hari</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Cek apakah variabel $kendaraan ada dan tidak kosong --}}
                        @forelse($kendaraan ?? [] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            {{-- Menggabungkan merek dan nama_model --}}
                            <td class="fw-semibold">{{ $item['merek'] ?? '' }} {{ $item['nama_model'] ?? '-' }}</td>
                            
                            {{-- Menggunakan kolom kategori --}}
                            <td>{{ $item['kategori'] ?? '-' }}</td>
                            
                            {{-- Menggunakan kolom nopol --}}
                            <td><code>{{ $item['nopol'] ?? '-' }}</code></td>
                            
                            {{-- Menggunakan kolom harga_sewa_per_hari --}}
                            <td>Rp {{ number_format($item['harga_sewa_per_hari'] ?? 0, 0, ',', '.') }}</td>
                            
                            <td>
                                <span class="badge bg-success">{{ $item['status_ketersediaan'] ?? 'Tersedia' }}</span>
                            </td>
                                <!-- <a href="{{ route('kendaraan.create') }}" class="btn btn-primary mb-3">Tambah Kendaraan</a> -->
                            

                                <td class="text-center">
                                    <a href="{{ route('kendaraan.edit', $item['id']) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                    <form action="{{ route('kendaraan.destroy', $item['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Belum ada data kendaraan yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection