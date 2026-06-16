@extends('layouts.app')

@section('title', 'Kirim Laporan')

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
<div class="page-title">Kirim Laporan & Pengaduan</div>

@if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="card" style="max-width:650px;">
    <form action="/mitra/laporan/store" method="POST">
        @csrf
        <div class="form-group">
            <label>Judul Laporan</label>
            <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Singkat dan jelas">
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori">
                <option value="">-- Pilih Kategori --</option>
                <option value="masalah_sewa" {{ old('kategori') == 'masalah_sewa' ? 'selected' : '' }}>Masalah Sewa</option>
                <option value="masalah_data" {{ old('kategori') == 'masalah_data' ? 'selected' : '' }}>Masalah Data</option>
                <option value="masalah_teknis" {{ old('kategori') == 'masalah_teknis' ? 'selected' : '' }}>Masalah Teknis</option>
                <option value="permintaan_perubahan" {{ old('kategori') == 'permintaan_perubahan' ? 'selected' : '' }}>Permintaan Perubahan</option>
                <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="5" placeholder="Jelaskan masalah atau permintaan kamu secara detail (minimal 20 karakter)...">{{ old('deskripsi') }}</textarea>
        </div>
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-green">Kirim Laporan</button>
            <a href="/mitra/laporan" class="btn btn-gray">Batal</a>
        </div>
    </form>
</div>
@endsection