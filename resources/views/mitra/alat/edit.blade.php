@extends('layouts.app')

@section('title', 'Edit Alat')

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
<div class="page-title">Edit Alat Pertanian</div>

@if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="card" style="max-width:700px;">
    <form action="/mitra/alat/update/{{ $alat->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" value="{{ $alat->nama_alat }}">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Pengolahan Tanah" {{ $alat->kategori == 'Pengolahan Tanah' ? 'selected' : '' }}>Pengolahan Tanah</option>
                    <option value="Penanaman" {{ $alat->kategori == 'Penanaman' ? 'selected' : '' }}>Penanaman</option>
                    <option value="Irigasi" {{ $alat->kategori == 'Irigasi' ? 'selected' : '' }}>Irigasi</option>
                    <option value="Perawatan" {{ $alat->kategori == 'Perawatan' ? 'selected' : '' }}>Perawatan</option>
                    <option value="Panen" {{ $alat->kategori == 'Panen' ? 'selected' : '' }}>Panen</option>
                    <option value="Pasca Panen" {{ $alat->kategori == 'Pasca Panen' ? 'selected' : '' }}>Pasca Panen</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3">{{ $alat->deskripsi }}</textarea>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Harga Sewa per Hari (Rp)</label>
                <input type="number" name="harga_sewa_per_hari" value="{{ $alat->harga_sewa_per_hari }}">
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" value="{{ $alat->stok }}" min="1">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="tersedia" {{ $alat->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="disewa" {{ $alat->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    <option value="perbaikan" {{ $alat->status == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ $alat->kecamatan }}">
            </div>
            <div class="form-group">
                <label>Kabupaten</label>
                <input type="text" name="kabupaten" value="{{ $alat->kabupaten }}">
            </div>
            <div class="form-group">
                <label>Provinsi</label>
                <input type="text" name="provinsi" value="{{ $alat->provinsi }}">
            </div>
        </div>

        <div class="form-group">
            <label>Foto Alat</label>

            @if($alat->foto)
                <div style="margin-bottom:10px;">
                    <p style="font-size:12px; color:#999; margin-bottom:5px;">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $alat->foto) }}"
                         alt="Foto Alat"
                         style="width:180px; height:120px; object-fit:cover; border-radius:8px; border:1px solid #333;">
                </div>
            @else
                <p style="font-size:12px; color:#999; margin-bottom:8px;">Belum ada foto.</p>
            @endif

            <input type="file" name="foto" id="foto" accept="image/jpg,image/jpeg,image/png"
                   style="color:#ccc;"
                   onchange="previewFoto(this)">
            <p style="font-size:11px; color:#777; margin-top:4px;">Kosongkan jika tidak ingin mengganti foto. Format: JPG, JPEG, PNG. Maks: 2MB.</p>

            <img id="preview" src="#" alt="Preview"
                 style="display:none; margin-top:10px; width:180px; height:120px; object-fit:cover; border-radius:8px; border:1px solid #2e7d32;">
        </div>

        <div style="display:flex; gap:10px; margin-top:10px;">
            <button type="submit" class="btn btn-green">Simpan Perubahan</button>
            <a href="/mitra/alat" class="btn btn-gray">Batal</a>
        </div>
    </form>
</div>

<script>
function previewFoto(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection