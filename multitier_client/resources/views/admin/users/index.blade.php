@extends('layouts.app')
@section('title', 'Kelola Pengguna & Role')

@section('content')
<div class="container">
    <h3 class="fw-bold text-primary-voya mb-4">Manajemen Pengguna & Role Voya-004</h3>

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
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status / Blacklist</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $u)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $u['name'] ?? '-' }}</td>
                            <td>{{ $u['email'] ?? '-' }}</td>
                            <td>
                                <span class="badge bg-secondary">Role ID: {{ $u['role_id'] ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ ($u['status_akun'] ?? 'Aktif') == 'Blacklist' ? 'danger' : 'success' }}">
                                    {{ $u['status_akun'] ?? 'Aktif' }}
                                </span>
                            </td>
                            <td>
                                <!-- Form Ubah Status / Blacklist -->
                                <form action="{{ route('admin.users.update', $u['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <!-- Contoh tombol toggle sederhana -->
                                    <input type="hidden" name="status_akun" value="{{ ($u['status_akun'] ?? 'Aktif') == 'Blacklist' ? 'Aktif' : 'Blacklist' }}">
                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                        {{ ($u['status_akun'] ?? 'Aktif') == 'Blacklist' ? 'Cabut Blacklist' : 'Blacklist' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection