@extends('layouts.app')

@section('title', 'Tambah Pra Panen')

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
<div class="page-title">Tambah Data Pra Panen</div>

@if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="card">
    <form action="/user/pra-panen/store" method="POST">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Kategori Tanaman</label>
                <select name="kategori_tanaman" id="kategori_tanaman" onchange="filterTanaman()">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($tanamanByKategori as $kategori => $list)
                        <option value="{{ $kategori }}" {{ old('kategori_tanaman') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nama Tanaman</label>
                <select name="nama_tanaman" id="nama_tanaman">
                    <option value="">-- Pilih Kategori Dulu --</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Jumlah Bibit</label>
                <input type="number" name="jumlah_bibit" value="{{ old('jumlah_bibit') }}" placeholder="Contoh: 50" step="0.01">
            </div>
            <div class="form-group">
                <label>Satuan Bibit</label>
                <select name="satuan_bibit">
                    <option value="kg" {{ old('satuan_bibit') == 'kg' ? 'selected' : '' }}>Kg</option>
                    <option value="ton" {{ old('satuan_bibit') == 'ton' ? 'selected' : '' }}>Ton</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Tanggal Tanam</label>
                <input type="date" name="tanggal_tanam" value="{{ old('tanggal_tanam') }}">
            </div>
            <div class="form-group">
                <label>Musim Saat Menanam</label>
                <select name="musim">
                    <option value="">-- Pilih Musim --</option>
                    <option value="hujan" {{ old('musim') == 'hujan' ? 'selected' : '' }}>Musim Hujan</option>
                    <option value="kemarau" {{ old('musim') == 'kemarau' ? 'selected' : '' }}>Musim Kemarau</option>
                    <option value="pancaroba" {{ old('musim') == 'pancaroba' ? 'selected' : '' }}>Pancaroba</option>
                </select>
            </div>
        </div>

        <div style="background:#f9fbe7; padding:15px; border-radius:8px; margin-bottom:15px;">
            <p style="font-size:13px; color:#555;">
                Lokasi lahan kamu: <strong>{{ Auth::user()->kecamatan }}, {{ Auth::user()->kabupaten }}</strong><br>
                <small style="color:#999;">Rekomendasi alat akan ditampilkan berdasarkan kecamatan ini.</small>
            </p>
        </div>

        <div style="display:flex; gap:10px; margin-top:10px;">
            <button type="submit" class="btn btn-green">Simpan dan Lihat Rekomendasi</button>
            <a href="/user/pra-panen" class="btn btn-gray">Batal</a>
        </div>
    </form>
</div>

<script>
    const tanamanData = @json($tanamanByKategori);
    function filterTanaman() {
        const kategori = document.getElementById('kategori_tanaman').value;
        const select = document.getElementById('nama_tanaman');
        select.innerHTML = '<option value="">-- Pilih Tanaman --</option>';
        if (kategori && tanamanData[kategori]) {
            tanamanData[kategori].forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.nama;
                opt.textContent = item.nama;
                select.appendChild(opt);
            });
        }
    }
    window.onload = () => filterTanaman();
</script>
@endsection