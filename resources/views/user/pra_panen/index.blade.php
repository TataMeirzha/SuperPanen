@extends('layouts.app')

@section('title', 'Pra Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/user/dashboard">Dashboard</a>
    <div class="menu-label">Pencatatan Panen</div>
    <a href="/user/pra-panen" class="active">Pra Panen</a>
    <a href="/user/pasca-panen">Pasca Panen</a>
    <div class="menu-label">Sewa Alat</div>
    <a href="/user/alat">Cari Alat Tani</a>
    <a href="/user/permintaan-sewa">Permintaan Sewa Saya</a>
    <div class="menu-label">Bantuan</div>
    <a href="/user/laporan">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Data Pra Panen Saya</div>

<a href="/user/pra-panen/create" class="btn btn-green" style="margin-bottom:15px;">Tambah Pra Panen</a>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanaman</th>
                <th>Jumlah Bibit</th>
                <th>Tanggal Tanam</th>
                <th>Musim</th>
                <th>Luas Lahan</th>
                <th>Estimasi Modal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($praPanen as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->nama_tanaman }}</strong><br>
                    <small style="color:#999;">{{ $item->kategori_tanaman }}</small>
                </td>
                <td>{{ $item->jumlah_bibit }} {{ $item->satuan_bibit }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_tanam)->format('d M Y') }}</td>
                <td>{{ ucfirst($item->musim) }}</td>
                <td>{{ $item->luas_lahan_rekomendasi }} Ha</td>
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
                        <a href="/user/pasca-panen/create/{{ $item->id }}" class="btn btn-blue" style="font-size:12px; padding:5px 12px;">Pasca Panen</a>
                    @else
                        <span style="color:#999; font-size:12px;">Selesai</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center; color:#999; padding:20px;">Belum ada data pra panen.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection