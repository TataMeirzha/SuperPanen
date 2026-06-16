@extends('layouts.app')

@section('title', 'Tambah Pasca Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/user/dashboard">Dashboard</a>
    <div class="menu-label">Pencatatan Panen</div>
    <a href="/user/pra-panen">Pra Panen</a>
    <a href="/user/pasca-panen" class="active">Pasca Panen</a>
    <div class="menu-label">Sewa Alat</div>
    <a href="/user/alat">Cari Alat Tani</a>
    <a href="/user/permintaan-sewa">Permintaan Sewa Saya</a>
    <div class="menu-label">Bantuan</div>
    <a href="/user/laporan">Laporan Saya</a>
@endsection

@section('content')
<div class="page-title">Tambah Data Pasca Panen</div>

@if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="card" style="border-left:5px solid #2e7d32; margin-bottom:20px;">
    <h4 style="color:#2e7d32; margin-bottom:10px;">Data Pra Panen Terkait</h4>
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:15px;">
        <div>
            <div style="color:#777; font-size:12px;">Tanaman</div>
            <div style="font-weight:bold;">{{ $praPanen->nama_tanaman }}</div>
        </div>
        <div>
            <div style="color:#777; font-size:12px;">Tanggal Tanam</div>
            <div>{{ \Carbon\Carbon::parse($praPanen->tanggal_tanam)->format('d M Y') }}</div>
        </div>
        <div>
            <div style="color:#777; font-size:12px;">Musim</div>
            <div>{{ ucfirst($praPanen->musim) }}</div>
        </div>
        <div>
            <div style="color:#777; font-size:12px;">Estimasi Modal</div>
            <div style="color:#2e7d32; font-weight:bold;">Rp {{ number_format($praPanen->estimasi_modal, 0, ',', '.') }}</div>
        </div>
        <div>
            <div style="color:#777; font-size:12px;">Luas Lahan</div>
            <div>{{ $praPanen->luas_lahan_rekomendasi }} Ha</div>
        </div>
    </div>
</div>

<div class="card">
    <form action="/user/pasca-panen/store" method="POST">
        @csrf
        <input type="hidden" name="pra_panen_id" value="{{ $praPanen->id }}">

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Tanggal Panen</label>
                <input type="date" name="tanggal_panen" value="{{ old('tanggal_panen') }}">
            </div>
            <div class="form-group">
                <label>Satuan Hasil</label>
                <select name="satuan_hasil">
                    <option value="kg">Kg</option>
                    <option value="ton">Ton</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Hasil Panen</label>
                <input type="number" name="hasil_panen" value="{{ old('hasil_panen') }}" placeholder="Contoh: 500" step="0.01" oninput="hitungKeuntungan()">
            </div>
            <div class="form-group">
                <label>Harga Jual per Kg (Rp)</label>
                <input type="number" name="harga_jual_per_kg" value="{{ old('harga_jual_per_kg') }}" placeholder="Contoh: 8000" step="0.01" oninput="hitungKeuntungan()">
            </div>
        </div>

        <div class="form-group">
            <label>Modal Real yang Digunakan (Rp)</label>
            <input type="number" name="modal_real" value="{{ old('modal_real') }}" placeholder="Contoh: 5000000" step="0.01" oninput="hitungKeuntungan()">
            <small>Estimasi modal sebelumnya: Rp {{ number_format($praPanen->estimasi_modal, 0, ',', '.') }}</small>
        </div>

        <div class="form-group">
            <label>Catatan (Opsional)</label>
            <textarea name="catatan" rows="2" placeholder="Catatan tambahan tentang hasil panen...">{{ old('catatan') }}</textarea>
        </div>

        <div id="preview" style="display:none; background:#f9fbe7; padding:15px; border-radius:8px; margin-bottom:15px;">
            <h4 style="color:#2e7d32; margin-bottom:10px;">Perkiraan Keuntungan</h4>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">
                <div>
                    <div style="color:#777; font-size:12px;">Total Pendapatan</div>
                    <div id="prev_pendapatan" style="font-weight:bold; color:#333;">Rp 0</div>
                </div>
                <div>
                    <div style="color:#777; font-size:12px;">Modal Real</div>
                    <div id="prev_modal" style="font-weight:bold; color:#c62828;">Rp 0</div>
                </div>
                <div>
                    <div style="color:#777; font-size:12px;">Keuntungan Bersih</div>
                    <div id="prev_keuntungan" style="font-weight:bold; font-size:16px;">Rp 0</div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-green">Simpan Data Pasca Panen</button>
            <a href="/user/pra-panen" class="btn btn-gray">Batal</a>
        </div>
    </form>
</div>

<script>
function hitungKeuntungan() {
    const hasil = parseFloat(document.querySelector('[name="hasil_panen"]').value) || 0;
    const satuan = document.querySelector('[name="satuan_hasil"]').value;
    const modal = parseFloat(document.querySelector('[name="modal_real"]').value) || 0;
    const harga = parseFloat(document.querySelector('[name="harga_jual_per_kg"]').value) || 0;
    const hasilKg = satuan === 'ton' ? hasil * 1000 : hasil;
    const pendapatan = hasilKg * harga;
    const keuntungan = pendapatan - modal;
    document.getElementById('preview').style.display = 'block';
    document.getElementById('prev_pendapatan').textContent = 'Rp ' + pendapatan.toLocaleString('id-ID');
    document.getElementById('prev_modal').textContent = 'Rp ' + modal.toLocaleString('id-ID');
    const el = document.getElementById('prev_keuntungan');
    el.textContent = (keuntungan >= 0 ? 'Rp ' : '-Rp ') + Math.abs(keuntungan).toLocaleString('id-ID');
    el.style.color = keuntungan >= 0 ? '#2e7d32' : '#c62828';
}
document.querySelector('[name="satuan_hasil"]').addEventListener('change', hitungKeuntungan);
</script>
@endsection