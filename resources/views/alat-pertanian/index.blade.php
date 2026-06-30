@extends('layouts.app')

@section('title', 'Pembuktian Database Terdistribusi')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/user/dashboard">Dashboard</a>
    <div class="menu-label">Database Terdistribusi</div>
    <a href="/alat-pertanian-gabungan" class="active">Bukti Fragmentasi</a>
@endsection

@section('content')
<div class="page-title">Pembuktian Fragmentasi Horizontal — Alat Pertanian</div>

<div class="alert-info">
    Data di bawah ini diambil secara bersamaan dari <strong>2 server MySQL berbeda</strong> melalui jaringan,
    lalu digabung dan diproses oleh aplikasi Laravel ini.
</div>

<div class="stat-grid">
    <div class="stat-card" style="border-left-color:#4caf50;">
        <div class="stat-number">{{ $totalServer1 }}</div>
        <div class="stat-label">Data di Server 1 (PC Saya) — Kab. Madiun</div>
    </div>
    <div class="stat-card" style="border-left-color:#1565c0;">
        <div class="stat-number">{{ $totalServer2 }}</div>
        <div class="stat-label">Data di Server 2 (PC Teman) — Luar Kab. Madiun</div>
    </div>
    <div class="stat-card" style="border-left-color:#a5d6a7;">
        <div class="stat-number">{{ $totalServer1 + $totalServer2 }}</div>
        <div class="stat-label">Total Gabungan Kedua Server</div>
    </div>
</div>

<div class="card">
    <h3>Detail Koneksi Server</h3>
    <table style="margin-top:10px;">
        <thead>
            <tr>
                <th>Server</th>
                <th>Database</th>
                <th>Lokasi Fisik</th>
                <th>Cakupan Data</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="badge badge-green">Server 1</span></td>
                <td>SuperPanen (mysql)</td>
                <td>PC Saya — {{ config('database.connections.mysql.host') }}</td>
                <td>Kabupaten Madiun</td>
                <td><span class="badge badge-green">Terhubung</span></td>
            </tr>
            <tr>
                <td><span class="badge badge-blue">Server 2</span></td>
                <td>db_superpanen_alat_luar (fragment2)</td>
                <td>PC Teman — {{ config('database.connections.fragment2.host') }}</td>
                <td>Di luar Kabupaten Madiun</td>
                <td><span class="badge badge-green">Terhubung</span></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="card">
    <h3>Data Gabungan Alat Pertanian (Real-time dari Kedua Server)</h3>
    <table style="margin-top:10px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Kategori</th>
                <th>Harga Sewa/Hari</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th>Asal Server</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataGabungan as $index => $alat)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $alat->nama_alat }}</td>
                <td>{{ $alat->kategori }}</td>
                <td>Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}</td>
                <td align="center">{{ $alat->stok }}</td>
                <td>
                    @if($alat->status === 'tersedia')
                        <span class="badge badge-green">Tersedia</span>
                    @elseif($alat->status === 'disewa')
                        <span class="badge badge-orange">Disewa</span>
                    @else
                        <span class="badge badge-red">Perbaikan</span>
                    @endif
                </td>
                <td>{{ $alat->kecamatan }}</td>
                <td>{{ $alat->kabupaten }}</td>
                <td>
                    @if($alat->asal_server === 'Server 1')
                        <span class="badge badge-green">{{ $alat->asal_server }}</span>
                    @else
                        <span class="badge badge-blue">{{ $alat->asal_server }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; color:#999; padding:20px;">
                    Belum ada data dari kedua server.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection