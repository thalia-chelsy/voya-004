@extends('layouts.app')
@section('title', 'Katalog Kendaraan')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h3 class="fw-bold text-primary-voya">Katalog Kendaraan Voya-004</h3>
            <p class="text-muted">Pilih kendaraan terbaik untuk perjalanan Anda.</p>
        </div>
        <div class="col-md-6">
            <form action="{{ route('penyewa.katalog') }}" method="GET" class="input-group">
                <!-- Pastikan name="cari" -->
                <input type="text" name="cari" class="form-control" placeholder="Cari merek atau model..." value="{{ request('cari') }}">
                <button class="btn btn-primary-voya" type="submit">Cari</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @forelse($kendaraan as $k)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <!-- Ubah dari $k->nama_model menjadi $k['nama_model'] -->
                    <h5 class="card-title fw-bold">{{ $k['nama_model'] }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $k['merek'] }} ({{ $k['tahun'] }}) - {{ $k['warna'] }}</h6>
                    <hr>
                    <p class="mb-1"><strong>Nopol:</strong> {{ $k['nopol'] }}</p>
                    <p class="mb-1"><strong>Kategori:</strong> {{ $k['kategori'] }}</p>
                    <p class="mb-1"><strong>Tarif:</strong> <span class="text-success fw-bold">Rp {{ number_format($k['harga_sewa_per_hari'], 0, ',', '.') }}</span> / hari</p>
                    <p class="mb-1"><strong>Kondisi:</strong> <span class="badge bg-success">{{ $k['kondisi_teknis'] }}</span></p>
                    <p class="mb-3"><strong>Status:</strong> <span class="badge bg-primary">{{ $k['status_ketersediaan'] }}</span></p>

                    @if($k['status_ketersediaan'] == 'Tersedia' && $k['kondisi_teknis'] == 'Layak Digunakan')
                        <!-- Form Ajukan Sewa -->
                        <form action="{{ route('transaksi.store') }}" method="POST" class="mt-3 bg-light p-3 rounded">
                            @csrf
                            <input type="hidden" name="kendaraan_id" value="{{ $k['id'] }}">
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Mulai Sewa:</label>
                                <input type="date" name="tgl_mulai" class="form-control form-control-sm" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Rencana Kembali:</label>
                                <input type="date" name="tgl_rencana_kembali" class="form-control form-control-sm" required min="{{ date('Y-m-d') }}">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary-voya w-100 mt-2">Ajukan Sewa</button>
                        </form>
                    @else
                        <button class="btn btn-sm btn-secondary w-100 mt-3" disabled>Tidak Tersedia</button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">Kendaraan tidak ditemukan.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $kendaraan->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection