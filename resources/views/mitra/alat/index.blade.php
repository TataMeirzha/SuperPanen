@extends('layouts.app')

@section('title', 'Daftar Alat Saya')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/mitra/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Alat</div>
    <a href="/mitra/alat" class="active">Daftar Alat Saya</a>
    <div class="menu-label">Permintaan Sewa</div>
    <a href="/mitra/permintaan-sewa">Permintaan Masuk</a>
    <div class="menu-label">Bantuan</div>
    <a href="/mitra/laporan">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Daftar Alat Pertanian Saya</div>

<a href="/mitra/alat/create" class="btn btn-green" style="margin-bottom:15px;">Tambah Alat Baru</a>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Kategori</th>
                <th>Harga Sewa/Hari</th>
                <th>Stok</th>
                <th>Kecamatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alat as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_alat }}</td>
                <td>{{ $item->kategori }}</td>
                <td>Rp {{ number_format($item->harga_sewa_per_hari, 0, ',', '.') }}</td>
                <td align="center">{{ $item->stok }}</td>
                <td>{{ $item->kecamatan }}</td>
                <td>
                    @if($item->status === 'tersedia')
                        <span class="badge badge-green">Tersedia</span>
                    @elseif($item->status === 'disewa')
                        <span class="badge badge-orange">Disewa</span>
                    @else
                        <span class="badge badge-red">Perbaikan</span>
                    @endif
                </td>
                <td style="display:flex; gap:5px;">
                    <a href="/mitra/alat/edit/{{ $item->id }}" class="btn btn-blue" style="font-size:12px; padding:5px 12px;">Edit</a>
                    <form action="/mitra/alat/{{ $item->id }}" method="POST" onsubmit="return confirm('Yakin hapus alat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red" style="font-size:12px; padding:5px 12px;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#999; padding:20px;">Belum ada alat terdaftar. <a href="/mitra/alat/create" style="color:#2e7d32;">Tambah sekarang</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection