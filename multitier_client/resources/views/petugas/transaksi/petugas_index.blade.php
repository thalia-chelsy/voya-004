@extends('layouts.app')
@section('title', 'Kelola Transaksi Sewa')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold text-primary-voya mb-3">Kelola Transaksi & Operasional Sewa</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-primary-voya">
                        id<th>ID</th>
                        <th>Penyewa</th>
                        <th>Kendaraan</th>
                        <th>Jadwal Sewa</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th>Aksi / Ubah Status</th>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index =>$t)
                        <tr>
                            <td>#{{ $t['id'] ?? '-' }}</td>
                            <td>{{ $t['user']['nama_lengkap'] ?? $t['penyewa']['nama_lengkap'] ?? '-' }}</td>
                            <td>{{ $t['kendaraan']['nama_kendaraan'] ?? $t['kendaraan']['nama_model'] ?? '-' }}</td>
                            <td>{{ $t['tgl_mulai'] ?? '-' }} s/d {{ $t['tgl_rencana_kembali'] ?? '-' }}</td>
                            <td>Rp {{ number_format($t['total_biaya'] ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($t['status'] == 'Menunggu Konfirmasi') bg-warning text-dark
                                    @elseif($t['status'] == 'Disetujui' || $t['status'] == 'Sedang Disewa') bg-primary
                                    @elseif($t['status'] == 'Selesai') bg-success
                                    @else bg-danger @endif">
                                    {{ $t['status'] ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('transaksis.updateStatus', $t['id']) }}" method="POST" class="d-flex gap-1">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm" style="width: 140px;" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Disetujui">Setujui</option>
                                        <option value="Ditolak">Tolak</option>
                                    </select>
                                    @if($t['status'] == 'Disetujui' || $t['status'] == 'Sedang Disewa')
                                        <a href="{{ route('petugas.transaksi.formSerahTerima', $t['id']) }}" class="btn btn-sm btn-primary fw-bold">Form Serah Terima</a>
                                    @else
                                        <span class="text-muted small">Selesai</span>
                                    @endif
                                    <button type="submit" class="btn btn-sm btn-primary-voya">Proses</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada transaksi sewa yang masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            
        </div>
    </div>
</div>
@endsection