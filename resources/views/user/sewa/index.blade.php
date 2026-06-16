@extends('layouts.app')

@section('title', 'Permintaan Sewa Saya')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/user/dashboard">Dashboard</a>
    <div class="menu-label">Pencatatan Panen</div>
    <a href="/user/pra-panen">Pra Panen</a>
    <a href="/user/pasca-panen">Pasca Panen</a>
    <div class="menu-label">Sewa Alat</div>
    <a href="/user/alat">Cari Alat Tani</a>
    <a href="/user/permintaan-sewa" class="active">Permintaan Sewa Saya</a>
    <div class="menu-label">Bantuan</div>
    <a href="/user/laporan">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Permintaan Sewa Saya</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Alat</th>
                <th>Mitra</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Durasi</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th>Catatan Mitra</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permintaan as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->alatPertanian->nama_alat ?? '-' }}</td>
                <td>{{ $item->alatPertanian->mitra->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                <td align="center">{{ $item->durasi_hari }} hari</td>
                <td>Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                <td>
                    @if($item->status === 'pending')
                        <span class="badge badge-orange">Menunggu</span>
                    @elseif($item->status === 'disetujui')
                        <span class="badge badge-green">Disetujui</span>
                    @elseif($item->status === 'ditolak')
                        <span class="badge badge-red">Ditolak</span>
                    @else
                        <span class="badge badge-gray">Selesai</span>
                    @endif
                </td>
                <td style="color:#555; font-size:12px;">{{ $item->catatan_mitra ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center; color:#999; padding:20px;">Belum ada permintaan sewa.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection