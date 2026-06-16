@extends('layouts.app')

@section('title', 'Laporan Saya')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/mitra/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Alat</div>
    <a href="/mitra/alat">Daftar Alat Saya</a>
    <div class="menu-label">Permintaan Sewa</div>
    <a href="/mitra/permintaan-sewa">Permintaan Masuk</a>
    <div class="menu-label">Bantuan</div>
    <a href="/mitra/laporan" class="active">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Laporan & Pengaduan Saya</div>

<a href="/mitra/laporan/create" class="btn btn-green" style="margin-bottom:15px;">Kirim Laporan Baru</a>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Balasan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ str_replace('_', ' ', ucfirst($item->kategori)) }}</td>
                <td>
                    @if($item->status === 'pending')
                        <span class="badge badge-orange">Pending</span>
                    @elseif($item->status === 'diproses')
                        <span class="badge badge-blue">Diproses</span>
                    @else
                        <span class="badge badge-green">Selesai</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                <td>
                    @if($item->balasan)
                        <button onclick="toggleBalasan({{ $item->id }})" class="btn btn-blue" style="font-size:12px; padding:5px 12px;">Lihat Balasan</button>
                    @else
                        <span style="color:#999; font-size:12px;">Belum dibalas</span>
                    @endif
                </td>
            </tr>
            @if($item->balasan)
            <tr id="balasan-{{ $item->id }}" style="display:none; background:#f9fbe7;">
                <td colspan="6" style="padding:12px;">
                    <strong style="color:#2e7d32;">Balasan Admin:</strong>
                    <p style="margin-top:5px; color:#333;">{{ $item->balasan }}</p>
                    <small style="color:#999;">{{ \Carbon\Carbon::parse($item->dibalas_at)->format('d M Y H:i') }}</small>
                </td>
            </tr>
            @endif
            @empty
            <tr><td colspan="6" style="text-align:center; color:#999; padding:20px;">Belum ada laporan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function toggleBalasan(id) {
    const el = document.getElementById('balasan-' + id);
    el.style.display = el.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endsection