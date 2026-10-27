@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Serah Terima Kendaraan (Check-Out / Check-In)</h2>
        <a href="{{ route('petugas.transaksi.petugas_index') }}" class="btn btn-outline-secondary btn-sm">← Kembali ke Semua Transaksi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Penyewa</th>
                            <th>Kendaraan</th>
                            <th>Jadwal Sewa</th>
                            <th>Status</th>
                            <th>Aksi Serah Terima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $t)
                        <tr>
                            <td>#{{ $t['id'] ?? '-' }}</td>
                            <td>{{ $t['user']['nama_lengkap'] ?? '-' }}</td>
                            <td>{{ $t['kendaraan']['nama_model'] ?? '-' }}</td>
                            <td>{{ $t['tgl_mulai'] ?? '-' }} s/d {{ $t['tgl_rencana_kembali'] ?? '-' }}</td>
                            <td>
                                @if($t['status'] == 'Disetujui')
                                    <span class="badge bg-info text-dark">Siap Check-Out</span>
                                @else
                                    <span class="badge bg-primary">Sedang Disewa (Siap Check-In)</span>
                                @endif
                            </td>
                            <td>
                                <!-- Tombol menuju form detail serah terima -->
                                <a href="{{ route('petugas.transaksi.formSerahTerima', $t['id']) }}" class="btn btn-sm btn-warning fw-bold">
                                    Proses Serah Terima
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada kendaraan yang perlu diserahterimakan saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection