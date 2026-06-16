@extends('layouts.app')

@section('title', 'Permintaan Sewa Masuk')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/mitra/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Alat</div>
    <a href="/mitra/alat">Daftar Alat Saya</a>
    <div class="menu-label">Permintaan Sewa</div>
    <a href="/mitra/permintaan-sewa" class="active">Permintaan Masuk</a>
    <div class="menu-label">Bantuan</div>
    <a href="/mitra/laporan">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Permintaan Sewa Masuk</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Petani</th>
                <th>Alat</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Durasi</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permintaan as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>
                    {{ $item->user->name ?? '-' }}<br>
                    <small style="color:#999;">{{ $item->user->no_hp ?? '' }}</small>
                </td>
                <td>{{ $item->alatPertanian->nama_alat ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                <td align="center">{{ $item->durasi_hari }} hari</td>
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
                <td>
                    @if($item->status === 'pending')
                        <button onclick="toggleAksi({{ $item->id }})" class="btn btn-blue" style="font-size:12px; padding:5px 12px;">Proses</button>
                    @elseif($item->status === 'disetujui')
                        <form action="/mitra/permintaan-sewa/{{ $item->id }}/status" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn btn-gray" style="font-size:12px; padding:5px 12px;">Tandai Selesai</button>
                        </form>
                    @endif
                </td>
            </tr>
            @if($item->catatan_user)
            <tr style="background:#f9fbe7;">
                <td colspan="9" style="padding:8px 12px; font-size:12px; color:#555;">
                    <strong>Catatan Petani:</strong> {{ $item->catatan_user }}
                </td>
            </tr>
            @endif
            {{-- Form Approve/Tolak --}}
            <tr id="aksi-{{ $item->id }}" style="display:none; background:#f5f5f5;">
                <td colspan="9" style="padding:15px;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                        <form action="/mitra/permintaan-sewa/{{ $item->id }}/status" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="disetujui">
                            <div class="form-group">
                                <label>Catatan (opsional)</label>
                                <input type="text" name="catatan_mitra" placeholder="Catatan untuk petani...">
                            </div>
                            <button type="submit" class="btn btn-green">Setujui Permintaan</button>
                        </form>
                        <form action="/mitra/permintaan-sewa/{{ $item->id }}/status" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="ditolak">
                            <div class="form-group">
                                <label>Alasan Penolakan</label>
                                <input type="text" name="catatan_mitra" placeholder="Alasan penolakan..." required>
                            </div>
                            <button type="submit" class="btn btn-red">Tolak Permintaan</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center; color:#999; padding:20px;">Belum ada permintaan sewa masuk.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function toggleAksi(id) {
    const el = document.getElementById('aksi-' + id);
    el.style.display = el.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endsection