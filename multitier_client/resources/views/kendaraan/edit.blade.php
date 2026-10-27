@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Data Kendaraan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kendaraan.update', $kendaraan['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Merek</label>
                            <input type="text" name="merek" class="form-control" value="{{ $kendaraan['merek'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Model</label>
                            <input type="text" name="nama_model" class="form-control" value="{{ $kendaraan['nama_model'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Plat (Nopol)</label>
                            <input type="text" name="nopol" class="form-control" value="{{ $kendaraan['nopol'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Mobil" {{ ($kendaraan['kategori'] ?? '') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                <option value="Motor" {{ ($kendaraan['kategori'] ?? '') == 'Motor' ? 'selected' : '' }}>Motor</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control" value="{{ $kendaraan['tahun'] ?? '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Warna</label>
                                <input type="text" name="warna" class="form-control" value="{{ $kendaraan['warna'] ?? '' }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Sewa per Hari (Rp)</label>
                            <input type="number" name="harga_sewa_per_hari" class="form-control" value="{{ $kendaraan['harga_sewa_per_hari'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Ketersediaan</label>
                            <select name="status_ketersediaan" class="form-select" required>
                                <option value="Tersedia" {{ ($kendaraan['status_ketersediaan'] ?? '') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Tidak Tersedia" {{ ($kendaraan['status_ketersediaan'] ?? '') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kondisi Teknis</label>
                            <select name="kondisi_teknis" class="form-select" required>
                                <option value="Layak Digunakan" {{ ($kendaraan['kondisi_teknis'] ?? '') == 'Layak Digunakan' ? 'selected' : '' }}>Layak Digunakan</option>
                                <option value="Perlu Pemeriksaan" {{ ($kendaraan['kondisi_teknis'] ?? '') == 'Perlu Pemeriksaan' ? 'selected' : '' }}>Perlu Pemeriksaan</option>
                                <option value="Dalam Perawatan" {{ ($kendaraan['kondisi_teknis'] ?? '') == 'Dalam Perawatan' ? 'selected' : '' }}>Dalam Perawatan</option>
                                <option value="Tidak Layak Jalan" {{ ($kendaraan['kondisi_teknis'] ?? '') == 'Tidak Layak Jalan' ? 'selected' : '' }}>Tidak Layak Jalan</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-warning">Perbarui Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection