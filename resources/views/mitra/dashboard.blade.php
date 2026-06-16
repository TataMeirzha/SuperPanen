@extends('layouts.app')

@section('title', 'Dashboard Mitra')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/mitra/dashboard" class="{{ request()->is('mitra/dashboard') ? 'active' : '' }}">Dashboard</a>

    <div class="menu-label">Kelola Alat</div>
    <a href="/mitra/alat" class="{{ request()->is('mitra/alat*') ? 'active' : '' }}">Daftar Alat Saya</a>

    <div class="menu-label">Permintaan Sewa</div>
    <a href="/mitra/permintaan-sewa" class="{{ request()->is('mitra/permintaan-sewa*') ? 'active' : '' }}">Permintaan Masuk</a>

    <div class="menu-label">Bantuan</div>
    <a href="/mitra/laporan" class="{{ request()->is('mitra/laporan*') ? 'active' : '' }}">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Dashboard Mitra</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $totalAlat }}</div>
        <div class="stat-label">Total Alat Terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalPermintaan }}</div>
        <div class="stat-label">Total Permintaan Sewa</div>
    </div>
    <div class="stat-card" style="border-left-color:#e65100;">
        <div class="stat-number" style="color:#e65100;">{{ $permintaanPending }}</div>
        <div class="stat-label">Permintaan Pending</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan Sewa</div>
    </div>
</div>

@if($permintaanPending > 0)
<div class="alert-info">
    Ada <strong>{{ $permintaanPending }} permintaan sewa</strong> yang menunggu persetujuan kamu.
    <a href="/mitra/permintaan-sewa" style="color:#1565c0; font-weight:bold;">Lihat sekarang</a>
</div>
@endif

<div class="card">
    <h3 style="color:#2e7d32; margin-bottom:15px;">Permintaan Sewa Terbaru</h3>
    <table>
        <thead>
            <tr>
                <th>Petani</th>
                <th>Alat</th>
                <th>Tanggal Mulai</th>
                <th>Durasi</th>
                <th>Total Biaya</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentPermintaan as $item)
            <tr>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->alatPertanian->nama_alat ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                <td>{{ $item->durasi_hari }} hari</td>
                <td>Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                <td>
                    @if($item->status === 'pending')
                        <span class="badge badge-orange">Pending</span>
                    @elseif($item->status === 'disetujui')
                        <span class="badge badge-green">Disetujui</span>
                    @elseif($item->status === 'ditolak')
                        <span class="badge badge-red">Ditolak</span>
                    @else
                        <span class="badge badge-gray">Selesai</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:#999; padding:20px;">Belum ada permintaan sewa.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection