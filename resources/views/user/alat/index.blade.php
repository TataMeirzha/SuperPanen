@extends('layouts.app')

@section('title', 'Cari Alat Tani')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/user/dashboard">Dashboard</a>
    <div class="menu-label">Pencatatan Panen</div>
    <a href="/user/pra-panen">Pra Panen</a>
    <a href="/user/pasca-panen">Pasca Panen</a>
    <div class="menu-label">Sewa Alat</div>
    <a href="/user/alat" class="active">Cari Alat Tani</a>
    <a href="/user/permintaan-sewa">Permintaan Sewa Saya</a>
    <div class="menu-label">Bantuan</div>
    <a href="/user/laporan">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Cari Alat Pertanian Terdekat</div>

<div class="card" style="margin-bottom:20px;">
    <form action="/user/alat" method="GET" style="display:grid; grid-template-columns:1fr 1fr auto; gap:15px; align-items:end;">
        <div class="form-group" style="margin:0;">
            <label>Kecamatan</label>
            <input type="text" name="kecamatan" value="{{ $kecamatan }}" placeholder="Nama kecamatan">
        </div>
        <div class="form-group" style="margin:0;">
            <label>Kabupaten</label>
            <input type="text" name="kabupaten" value="{{ $kabupaten }}" placeholder="Nama kabupaten">
        </div>
        <button type="submit" class="btn btn-green">Cari Alat</button>
    </form>
</div>

@if($alat->count() > 0)
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:20px;">
    @foreach($alat as $item)
    <div class="card" style="border-top:4px solid #2e7d32; padding:0; overflow:hidden;">

        {{-- FOTO ALAT --}}
        @if($item->foto)
            <img src="{{ asset('storage/' . $item->foto) }}"
                alt="{{ $item->nama_alat }}"
                style="width:100%; height:180px; object-fit:cover;">
        @else
            <div style="width:100%; height:180px; background:rgba(46,125,50,0.15); display:flex; align-items:center; justify-content:center;">
                <span style="color:rgba(255,255,255,0.3); font-size:13px;">Tidak ada foto</span>
            </div>
        @endif

        {{-- DETAIL ALAT --}}
        <div style="padding:16px;">
            <h3 style="color:#2e7d32; margin-bottom:8px;">{{ $item->nama_alat }}</h3>
            <p style="color:#777; font-size:13px; margin-bottom:10px;">{{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            <div style="font-size:13px; margin-bottom:5px; color:#aaa;">
                Kategori: <strong style="color:white;">{{ $item->kategori }}</strong>
            </div>
            <div style="font-size:13px; margin-bottom:5px; color:#aaa;">
                Lokasi: <strong style="color:white;">{{ $item->kecamatan }}, {{ $item->kabupaten }}</strong>
            </div>
            <div style="font-size:13px; margin-bottom:5px; color:#aaa;">
                Mitra: <strong style="color:white;">{{ $item->mitra->name ?? '-' }}</strong>
            </div>
            <div style="font-size:15px; font-weight:bold; color:#4caf50; margin-bottom:15px;">
                Rp {{ number_format($item->harga_sewa_per_hari, 0, ',', '.') }} / hari
            </div>

            <button onclick="toggleSewa({{ $item->id }})" class="btn btn-green" style="width:100%;">Sewa Alat Ini</button>

            <div id="sewa-{{ $item->id }}" style="display:none; margin-top:15px; border-top:1px solid rgba(255,255,255,0.1); padding-top:15px;">
                <form action="/user/permintaan-sewa/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="alat_pertanian_id" value="{{ $item->id }}">

                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" min="{{ date('Y-m-d') }}" onchange="hitungBiaya({{ $item->id }}, {{ $item->harga_sewa_per_hari }})">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" min="{{ date('Y-m-d') }}" onchange="hitungBiaya({{ $item->id }}, {{ $item->harga_sewa_per_hari }})">
                    </div>
                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <input type="text" name="catatan_user" placeholder="Pesan untuk mitra...">
                    </div>

                    {{-- VERIFIKASI KTP --}}
                    <div class="form-group">
                        <label style="color:#4caf50; font-weight:bold;">Foto KTP <span style="color:#e57373;">*</span></label>
                        <p style="font-size:11px; color:#777; margin-bottom:8px;">Upload foto KTP kamu sebagai verifikasi identitas penyewa. Format: JPG, JPEG, PNG. Maks: 2MB.</p>
                        <input type="file" name="foto_ktp" id="foto_ktp_{{ $item->id }}"
                               accept="image/jpg,image/jpeg,image/png"
                               required
                               style="color:#ccc;"
                               onchange="previewKtp({{ $item->id }}, this)">
                        <img id="preview_ktp_{{ $item->id }}" src="#" alt="Preview KTP"
                             style="display:none; margin-top:10px; width:100%; height:130px; object-fit:cover; border-radius:8px; border:1px solid #2e7d32;">
                    </div>

                    <div id="preview-{{ $item->id }}" style="display:none; background:rgba(46,125,50,0.2); padding:10px; border-radius:6px; margin-bottom:10px; font-size:13px; color:white;">
                        Durasi: <span id="durasi-{{ $item->id }}">0</span> hari |
                        Total: <strong id="total-{{ $item->id }}">Rp 0</strong>
                    </div>

                    <button type="submit" class="btn btn-green" style="width:100%;">Kirim Permintaan Sewa</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card" style="text-align:center; padding:40px;">
    <p style="color:#999; margin-bottom:15px;">Tidak ada alat tersedia di kecamatan <strong>{{ $kecamatan }}</strong> atau kabupaten <strong>{{ $kabupaten }}</strong>.</p>
    <p style="color:#777; font-size:13px;">Coba cari dengan nama kecamatan atau kabupaten yang berbeda.</p>
</div>
@endif

<script>
function toggleSewa(id) {
    const el = document.getElementById('sewa-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

function hitungBiaya(id, hargaPerHari) {
    const mulai = document.querySelector('#sewa-' + id + ' [name="tanggal_mulai"]').value;
    const selesai = document.querySelector('#sewa-' + id + ' [name="tanggal_selesai"]').value;
    if (mulai && selesai) {
        const diff = (new Date(selesai) - new Date(mulai)) / (1000 * 60 * 60 * 24);
        if (diff > 0) {
            document.getElementById('preview-' + id).style.display = 'block';
            document.getElementById('durasi-' + id).textContent = diff;
            document.getElementById('total-' + id).textContent = 'Rp ' + (diff * hargaPerHari).toLocaleString('id-ID');
        }
    }
}

function previewKtp(id, input) {
    const preview = document.getElementById('preview_ktp_' + id);
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