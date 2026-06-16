@extends('layouts.app')

@section('title', 'Kelola Admin Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/superadmin/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Sistem</div>
    <a href="/superadmin/users">Kelola User</a>
    <a href="/superadmin/admin-panen" class="active">Kelola Admin Panen</a>
    <div class="menu-label">Laporan</div>
    <a href="/superadmin/laporan">Pusat Laporan</a>
@endsection

@section('content')
<div class="page-title">Kelola Admin Panen</div>

<a href="/superadmin/admin-panen/create" class="btn btn-green" style="margin-bottom:15px;">Tambah Admin Panen</a>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $index => $admin)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->no_hp }}</td>
                <td>
                    @if($admin->is_active)
                        <span class="badge badge-green">Aktif</span>
                    @else
                        <span class="badge badge-red">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <form action="/superadmin/admin-panen/{{ $admin->id }}" method="POST" onsubmit="return confirm('Yakin hapus admin ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red" style="font-size:12px; padding:5px 12px;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:#999; padding:20px;">Belum ada admin panen.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection