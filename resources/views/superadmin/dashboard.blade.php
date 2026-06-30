@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/superadmin/dashboard" class="{{ request()->is('superadmin/dashboard') ? 'active' : '' }}">Dashboard</a>

    <div class="menu-label">Kelola Sistem</div>
    <a href="/superadmin/users" class="{{ request()->is('superadmin/users*') ? 'active' : '' }}">Kelola User</a>
    <a href="/superadmin/admin-panen" class="{{ request()->is('superadmin/admin-panen*') ? 'active' : '' }}">Kelola Admin Panen</a>

    <div class="menu-label">Laporan</div>
    <a href="/superadmin/laporan" class="{{ request()->is('superadmin/laporan*') ? 'active' : '' }}">Pusat Laporan</a>

    <div class="menu-label">Database Terdistribusi</div>
    <a href="/alat-pertanian-gabungan" class="{{ request()->is('alat-pertanian-gabungan*') ? 'active' : '' }}">Bukti Fragmentasi</a>
@endsection

@section('content')
<div class="page-title">Dashboard Super Admin</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $totalUser }}</div>
        <div class="stat-label">Total Petani</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalMitra }}</div>
        <div class="stat-label">Total Mitra</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalPraPanen }}</div>
        <div class="stat-label">Total Pra Panen</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalPascaPanen }}</div>
        <div class="stat-label">Total Pasca Panen</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalAlat }}</div>
        <div class="stat-label">Total Alat Terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalSewa }}</div>
        <div class="stat-label">Total Permintaan Sewa</div>
    </div>
    <div class="stat-card" style="border-left-color: #c62828;">
        <div class="stat-number" style="color: #c62828;">{{ $laporanPending }}</div>
        <div class="stat-label">Laporan Belum Dibalas</div>
    </div>
</div>

@if($laporanPending > 0)
<div class="alert-info">
    Ada <strong>{{ $laporanPending }} laporan</strong> yang belum dibalas.
    <a href="/superadmin/laporan" style="color:#1565c0; font-weight:bold;">Lihat sekarang</a>
</div>
@endif

@if($notifikasi->count() > 0)
<div class="card">
    <h3 style="color:#2e7d32; margin-bottom:15px;">Notifikasi Terbaru</h3>
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
@endsection