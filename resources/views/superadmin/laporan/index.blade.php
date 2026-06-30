@extends('layouts.app')

@section('title', 'Pusat Laporan')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/superadmin/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Sistem</div>
    <a href="/superadmin/users">Kelola User</a>
    <a href="/superadmin/admin-panen">Kelola Admin Panen</a>
    <div class="menu-label">Laporan</div>
    <a href="/superadmin/laporan" class="active">Pusat Laporan</a>
    <div class="menu-label">Database Terdistribusi</div>
    <a href="/alat-pertanian-gabungan" class="{{ request()->is('alat-pertanian-gabungan*') ? 'active' : '' }}">Bukti Fragmentasi</a>
@endsection

@section('content')
<div class="page-title">Pusat Laporan & Pengaduan</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pengirim</th>
                <th>Role</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->pengirim->name ?? '-' }}</td>
                <td>
                    <span class="badge {{ $item->pengirim->role === 'mitra' ? 'badge-blue' : 'badge-green' }}">
                        {{ ucfirst($item->pengirim->role ?? '-') }}
                    </span>
                </td>
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
                    <button onclick="toggleBalas({{ $item->id }})" class="btn btn-blue" style="font-size:12px; padding:5px 12px;">
                        {{ $item->status === 'selesai' ? 'Lihat' : 'Balas' }}
                    </button>
                </td>
            </tr>
            {{-- Detail & Form Balas --}}
            <tr id="detail-{{ $item->id }}" style="display:none; background:#f9fbe7;">
                <td colspan="8" style="padding:15px;">
                    <strong>Deskripsi:</strong>
                    <p style="margin:8px 0; color:#555;">{{ $item->deskripsi }}</p>
                    @if($item->balasan)
                        <div style="background:#e8f5e9; padding:10px; border-radius:8px; margin-top:10px;">
                            <strong style="color:#2e7d32;">Balasan Admin:</strong>
                            <p style="margin-top:5px; color:#333;">{{ $item->balasan }}</p>
                            <small style="color:#999;">{{ \Carbon\Carbon::parse($item->dibalas_at)->format('d M Y H:i') }}</small>
                        </div>
                    @endif
                    @if($item->status !== 'selesai')
                        <form action="/superadmin/laporan/{{ $item->id }}/balas" method="POST" style="margin-top:15px;">
                            @csrf
                            <div class="form-group">
                                <label>Tulis Balasan</label>
                                <textarea name="balasan" rows="3" placeholder="Tulis balasan untuk laporan ini..." style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; outline:none;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-green">Kirim Balasan</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#999; padding:20px;">Belum ada laporan masuk.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function toggleBalas(id) {
    const el = document.getElementById('detail-' + id);
    el.style.display = el.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endsection