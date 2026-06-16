@extends('layouts.app')

@section('title', 'Data Pra Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/admin-panen/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Data</div>
    <a href="/admin-panen/pra-panen" class="active">Data Pra Panen</a>
    <a href="/admin-panen/pasca-panen">Data Pasca Panen</a>
@endsection

@section('content')
<div class="page-title">Data Pra Panen Seluruh Petani</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Petani</th>
                <th>Tanaman</th>
                <th>Jumlah Bibit</th>
                <th>Tanggal Tanam</th>
                <th>Musim</th>
                <th>Kecamatan</th>
                <th>Estimasi Modal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($praPanen as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->nama_tanaman }}</td>
                <td>{{ $item->jumlah_bibit }} {{ $item->satuan_bibit }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_tanam)->format('d M Y') }}</td>
                <td>{{ ucfirst($item->musim) }}</td>
                <td>{{ $item->kecamatan }}</td>
                <td>Rp {{ number_format($item->estimasi_modal, 0, ',', '.') }}</td>
                <td>
                    @if($item->status === 'selesai')
                        <span class="badge badge-green">Selesai</span>
                    @else
                        <span class="badge badge-orange">Aktif</span>
                    @endif
                </td>
                <td>
                    <form action="/admin-panen/pra-panen/{{ $item->id }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red" style="font-size:12px; padding:5px 12px;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center; color:#999; padding:20px;">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection