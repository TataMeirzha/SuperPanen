@extends('layouts.app')

@section('title', 'Pasca Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/user/dashboard">Dashboard</a>
    <div class="menu-label">Pencatatan Panen</div>
    <a href="/user/pra-panen">Pra Panen</a>
    <a href="/user/pasca-panen" class="active">Pasca Panen</a>
    <div class="menu-label">Sewa Alat</div>
    <a href="/user/alat">Cari Alat Tani</a>
    <a href="/user/permintaan-sewa">Permintaan Sewa Saya</a>
    <div class="menu-label">Bantuan</div>
    <a href="/user/laporan">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Data Pasca Panen Saya</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanaman</th>
                <th>Tanggal Panen</th>
                <th>Hasil Panen</th>
                <th>Modal Real</th>
                <th>Total Pendapatan</th>
                <th>Keuntungan Bersih</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pascaPanen as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->praPanen->nama_tanaman ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_panen)->format('d M Y') }}</td>
                <td>{{ $item->hasil_panen }} {{ $item->satuan_hasil }}</td>
                <td>Rp {{ number_format($item->modal_real, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                <td>
                    @if($item->keuntungan_bersih >= 0)
                        <span style="color:#2e7d32; font-weight:bold;">Rp {{ number_format($item->keuntungan_bersih, 0, ',', '.') }}</span>
                    @else
                        <span style="color:red; font-weight:bold;">-Rp {{ number_format(abs($item->keuntungan_bersih), 0, ',', '.') }}</span>
                    @endif
                </td>
                <td style="color:#777; font-size:12px;">{{ $item->catatan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#999; padding:20px;">Belum ada data pasca panen.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection