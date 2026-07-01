@extends('layouts.app')

@section('title', 'Tambah Alat')

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
<div class="page-title">Tambah Alat Pertanian</div>

@if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="card" style="max-width:700px;">
    <form action="/mitra/alat/store" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" placeholder="Contoh: Traktor Roda Dua">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Pengolahan Tanah" {{ old('kategori') == 'Pengolahan Tanah' ? 'selected' : '' }}>Pengolahan Tanah</option>
                    <option value="Penanaman" {{ old('kategori') == 'Penanaman' ? 'selected' : '' }}>Penanaman</option>
                    <option value="Irigasi" {{ old('kategori') == 'Irigasi' ? 'selected' : '' }}>Irigasi</option>
                    <option value="Perawatan" {{ old('kategori') == 'Perawatan' ? 'selected' : '' }}>Perawatan</option>
                    <option value="Panen" {{ old('kategori') == 'Panen' ? 'selected' : '' }}>Panen</option>
                    <option value="Pasca Panen" {{ old('kategori') == 'Pasca Panen' ? 'selected' : '' }}>Pasca Panen</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat alat...">{{ old('deskripsi') }}</textarea>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Harga Sewa per Hari (Rp)</label>
                <input type="number" name="harga_sewa_per_hari" value="{{ old('harga_sewa_per_hari') }}" placeholder="Contoh: 350000">
            </div>
            <div class="form-group">
                <label>Stok / Jumlah Unit</label>
                <input type="number" name="stok" value="{{ old('stok', 1) }}" min="1">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', Auth::user()->kecamatan) }}">
            </div>
            <div class="form-group">
                <label>Kabupaten</label>
                <input type="text" name="kabupaten" value="{{ old('kabupaten', Auth::user()->kabupaten) }}">
            </div>
            <div class="form-group">
                <label>Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', Auth::user()->provinsi) }}">
            </div>
        </div>

        {{-- UPLOAD FOTO --}}
        <div class="form-group">
            <label>Foto Alat (Opsional)</label>
            <input type="file" name="foto" accept="image/*" onchange="previewFoto(event)" style="padding:8px;">
            <small>Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
        </div>

        {{-- PREVIEW FOTO --}}
        <div id="preview-container" style="display:none; margin-bottom:15px;">
            <p style="color:rgba(255,255,255,0.7); font-size:13px; margin-bottom:8px;">Preview:</p>
            <img id="preview-foto" src="" alt="Preview"
                style="max-width:250px; max-height:180px; border-radius:8px; border:1px solid rgba(255,255,255,0.2); object-fit:cover;">
        </div>

        <div style="display:flex; gap:10px; margin-top:10px;">
            <button type="submit" class="btn btn-green">Simpan Alat</button>
            <a href="/mitra/alat" class="btn btn-gray">Batal</a>
        </div>
    </form>
</div>

<script>
function previewFoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-foto').src = e.target.result;
            document.getElementById('preview-container').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection