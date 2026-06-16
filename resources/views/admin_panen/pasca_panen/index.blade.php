@extends('layouts.app')

@section('title', 'Data Pasca Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/admin-panen/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Data</div>
    <a href="/admin-panen/pra-panen">Data Pra Panen</a>
    <a href="/admin-panen/pasca-panen" class="active">Data Pasca Panen</a>
@endsection

@section('content')
<div class="page-title">Data Pasca Panen Seluruh Petani</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Petani</th>
                <th>Tanaman</th>
                <th>Tanggal Panen</th>
                <th>Hasil Panen</th>
                <th>Modal Real</th>
                <th>Total Pendapatan</th>
                <th>Keuntungan Bersih</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pascaPanen as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
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
                <td>
                    <form action="/admin-panen/pasca-panen/{{ $item->id }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red" style="font-size:12px; padding:5px 12px;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center; color:#999; padding:20px;">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection