@extends('layouts.app')

@section('title', 'Kelola User')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/superadmin/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Sistem</div>
    <a href="/superadmin/users" class="active">Kelola User</a>
    <a href="/superadmin/admin-panen">Kelola Admin Panen</a>
    <div class="menu-label">Laporan</div>
    <a href="/superadmin/laporan">Pusat Laporan</a>
@endsection

@section('content')
<div class="page-title">Kelola User & Mitra</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role === 'mitra')
                        <span class="badge badge-blue">Mitra</span>
                    @else
                        <span class="badge badge-green">Petani</span>
                    @endif
                </td>
                <td>{{ $user->kecamatan }}</td>
                <td>{{ $user->kabupaten }}</td>
                <td>
                    @if($user->is_active)
                        <span class="badge badge-green">Aktif</span>
                    @else
                        <span class="badge badge-red">Nonaktif</span>
                    @endif
                </td>
                <td style="display:flex; gap:5px;">
                    <form action="/superadmin/users/{{ $user->id }}/toggle" method="POST">
                        @csrf
                        <button type="submit" class="btn {{ $user->is_active ? 'btn-orange' : 'btn-green' }}" style="font-size:12px; padding:5px 12px;">
                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    <form action="/superadmin/users/{{ $user->id }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red" style="font-size:12px; padding:5px 12px;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#999; padding:20px;">Belum ada user terdaftar.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection