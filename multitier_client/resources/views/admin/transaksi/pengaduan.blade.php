@extends('layouts.app')
@section('title', 'Laporan Pengaduan Kendaraan')

@section('content')
<div class="container">
    <!-- Navigasi Menu Bagian -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary-voya">Kelola Laporan & Pengaduan Voya-004</h3>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-primary">Pantau Transaksi</a>
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-primary active">Laporan Pengaduan</a>
            <a href="{{ route('admin.laporan.inspeksi') }}" class="btn btn-outline-primary">Inspeksi Teknis</a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Pelapor</th>
                            <th>Kendaraan</th>
                            <th>Jenis Pengaduan / Masalah</th>
                            <th>Tanggal Laporan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduans as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <!-- Sesuaikan key nama user/pelapor -->
                            <td class="fw-bold">{{ $p['user']['name'] ?? $p['user']['nama_lengkap'] ?? 'User' }}</td>
                            
                            <!-- Sesuaikan key nama kendaraan -->
                            <td>{{ $p['kendaraan']['nama_model'] ?? $p['kendaraan']['nama_kendaraan'] ?? '-' }}</td>
                            
                            <!-- Sesuaikan key isi pengaduan (di database kolomnya 'isi_pengaduan') -->
                            <td>{{ $p['isi_pengaduan'] ?? $p['deskripsi_pengaduan'] ?? $p['catatan'] ?? '-' }}</td>
                            
                            <td>{{ $p['created_at'] ?? '-' }}</td>
                            <td>
                                <!-- Sesuaikan key status (di database kolomnya 'status') -->
                                <span class="badge bg-warning text-dark">{{ $p['status'] ?? $p['status_pengaduan'] ?? 'Menunggu' }}</span>
                            </td>
                            <!-- Di dalam loop tabel pengaduan (pengaduan.blade.php) -->
                            <td>
                                <!-- Tombol pemicu modal -->
                                <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalTanggapi{{ $p['id'] }}">
                                    Tanggapi
                                </button>

                                <!-- Modal Form Tanggapan -->
                                <div class="modal fade" id="modalTanggapi{{ $p['id'] }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('admin.pengaduan.tanggapi', $p['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Tanggapi Pengaduan: {{ $p['kendaraan']['nama_kendaraan'] ?? 'Kendaraan' }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <p class="mb-2"><strong>Keluhan Penyewa:</strong><br>{{ $p['isi_pengaduan'] ?? '-' }}</p>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Status Pengaduan</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="Diproses" {{ ($p['status'] ?? '') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                            <option value="Selesai" {{ ($p['status'] ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai / Ditangani</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Tanggapan / Solusi Admin</label>
                                                        <textarea name="tanggapan" class="form-control" rows="4" placeholder="Tulis instruksi atau solusi untuk penyewa / petugas bengkel..." required>{{ $p['tanggapan'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Tanggapan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada laporan pengaduan kendaraan saat ini.</td>
                        </tr>
                        @endforelse
                                            </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection