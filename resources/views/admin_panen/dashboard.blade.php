@extends('layouts.app')

@section('title', 'Dashboard Admin Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/admin-panen/dashboard" class="{{ request()->is('admin-panen/dashboard') ? 'active' : '' }}">Dashboard</a>
    <div class="menu-label">Kelola Data</div>
    <a href="/admin-panen/pra-panen" class="{{ request()->is('admin-panen/pra-panen*') ? 'active' : '' }}">Data Pra Panen</a>
    <a href="/admin-panen/pasca-panen" class="{{ request()->is('admin-panen/pasca-panen*') ? 'active' : '' }}">Data Pasca Panen</a>
@endsection

@section('content')
<div class="page-title">Dashboard Admin Panen</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $totalUser }}</div>
        <div class="stat-label">Total Petani</div>
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
        <div class="stat-number">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
        <div class="stat-label">Total Keuntungan Petani</div>
    </div>
</div>

<div class="card">
    <h3 style="color:#2e7d32; margin-bottom:15px;">Aktivitas Pra Panen Terbaru</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Petani</th>
                <th>Tanaman</th>
                <th>Tanggal Tanam</th>
                <th>Kecamatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentPraPanen as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->nama_tanaman }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_tanam)->format('d M Y') }}</td>
                <td>{{ $item->kecamatan }}</td>
                <td>
                    @if($item->status === 'selesai')
                        <span class="badge badge-green">Selesai</span>
                    @else
                        <span class="badge badge-orange">Aktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:#999; padding:20px;">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection