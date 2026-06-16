@extends('layouts.app')

@section('title', 'Dashboard Petani')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/user/dashboard" class="{{ request()->is('user/dashboard') ? 'active' : '' }}">Dashboard</a>

    <div class="menu-label">Pencatatan Panen</div>
    <a href="/user/pra-panen" class="{{ request()->is('user/pra-panen*') ? 'active' : '' }}">Pra Panen</a>
    <a href="/user/pasca-panen" class="{{ request()->is('user/pasca-panen*') ? 'active' : '' }}">Pasca Panen</a>

    <div class="menu-label">Sewa Alat</div>
    <a href="/user/alat" class="{{ request()->is('user/alat*') ? 'active' : '' }}">Cari Alat Tani</a>
    <a href="/user/permintaan-sewa" class="{{ request()->is('user/permintaan-sewa*') ? 'active' : '' }}">Permintaan Sewa Saya</a>

    <div class="menu-label">Bantuan</div>
    <a href="/user/laporan" class="{{ request()->is('user/laporan*') ? 'active' : '' }}">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Dashboard Petani</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $totalPraPanen }}</div>
        <div class="stat-label">Total Pra Panen</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalPascaPanen }}</div>
        <div class="stat-label">Total Pasca Panen</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
        <div class="stat-label">Total Keuntungan Bersih</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalSewa }}</div>
        <div class="stat-label">Total Sewa Alat</div>
    </div>
</div>

@if($notifikasi->count() > 0)
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h3 style="color:#2e7d32;">Notifikasi Terbaru</h3>
        <a href="/notifikasi" style="color:#2e7d32; font-size:13px;">Lihat Semua</a>
    </div>
    @foreach($notifikasi as $notif)
    <div style="padding:10px; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <strong style="font-size:13px;">{{ $notif->judul }}</strong>
            <p style="font-size:12px; color:#777; margin-top:3px;">{{ $notif->pesan }}</p>
        </div>
        <a href="/notifikasi/{{ $notif->id }}/baca" class="btn btn-gray" style="font-size:12px; padding:5px 12px;">Baca</a>
    </div>
    @endforeach
</div>
@endif

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h3 style="color:#2e7d32;">Aktivitas Pra Panen Terbaru</h3>
        <a href="/user/pra-panen/create" class="btn btn-green" style="font-size:12px;">Tambah Baru</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanaman</th>
                <th>Tanggal Tanam</th>
                <th>Musim</th>
                <th>Estimasi Modal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentPraPanen as $item)
            <tr>
                <td>{{ $item->nama_tanaman }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_tanam)->format('d M Y') }}</td>
                <td>{{ ucfirst($item->musim) }}</td>
                <td>Rp {{ number_format($item->estimasi_modal, 0, ',', '.') }}</td>
                <td>
                    @if($item->status === 'selesai')
                        <span class="badge badge-green">Selesai</span>
                    @else
                        <span class="badge badge-orange">Aktif</span>
                    @endif
                </td>
                <td>
                    @if($item->status !== 'selesai')
                        <a href="/user/pasca-panen/create/{{ $item->id }}" class="btn btn-blue" style="font-size:12px; padding:5px 12px;">Tambah Pasca Panen</a>
                    @else
                        <span style="color:#999; font-size:12px;">Selesai</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:#999; padding:20px;">Belum ada data. <a href="/user/pra-panen/create" style="color:#2e7d32;">Tambah sekarang</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection