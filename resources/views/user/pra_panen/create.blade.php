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
<style>
    .custom-dropdown { position: relative; }
    .dd-toggle {
        width: 100%;
        text-align: left;
        background: #1a1a1a;
        color: #ffffff;
        border: 1px solid #2e7d32;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .dd-toggle:hover {
        border-color: #00e676;
    }
    .dd-arrow {
        font-size: 12px;
        color: #4caf50;
        transition: transform 0.2s;
    }
    .dd-toggle.open .dd-arrow {
        transform: rotate(180deg);
    }
    .dd-list {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: #1e1e1e;
        border: 1px solid #2e7d32;
        border-radius: 6px;
        max-height: 220px;
        overflow-y: auto;
        z-index: 50;
    }
    .dd-item {
        padding: 10px 12px;
        font-size: 14px;
        color: #e0e0e0;
        cursor: pointer;
    }
    .dd-item:hover, .dd-item.disabled-hover {
        background: #2e4d32;
        color: #ffffff;
    }
    .dd-item.muted {
        color: #777;
        cursor: default;
    }
    .dd-item.muted:hover {
        background: transparent;
        color: #777;
    }
</style>

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
                <div class="custom-dropdown" id="dd-kategori">
                    <button type="button" class="dd-toggle">
                        <span class="dd-label">-- Pilih Kategori --</span>
                        <i class="ti ti-chevron-down dd-arrow"></i>
                    </button>
                    <div class="dd-list">
                        @foreach($tanamanByKategori as $kategori => $list)
                            <div class="dd-item" data-value="{{ $kategori }}">{{ $kategori }}</div>
                        @endforeach
                    </div>
                    <input type="hidden" name="kategori_tanaman" id="kategori_tanaman" value="{{ old('kategori_tanaman') }}">
                </div>
            </div>
            <div class="form-group">
                <label>Nama Tanaman</label>
                <div class="custom-dropdown" id="dd-tanaman">
                    <button type="button" class="dd-toggle">
                        <span class="dd-label">-- Pilih Kategori Dulu --</span>
                        <i class="ti ti-chevron-down dd-arrow"></i>
                    </button>
                    <div class="dd-list"></div>
                    <input type="hidden" name="nama_tanaman" id="nama_tanaman" value="{{ old('nama_tanaman') }}">
                </div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Jumlah Bibit</label>
                <input type="number" name="jumlah_bibit" value="{{ old('jumlah_bibit') }}" placeholder="Contoh: 50" step="0.01">
            </div>
            <div class="form-group">
                <label>Satuan Bibit</label>
                <div class="custom-dropdown" id="dd-satuan">
                    <button type="button" class="dd-toggle">
                        <span class="dd-label">{{ old('satuan_bibit') == 'ton' ? 'Ton' : 'Kg' }}</span>
                        <i class="ti ti-chevron-down dd-arrow"></i>
                    </button>
                    <div class="dd-list">
                        <div class="dd-item" data-value="kg">Kg</div>
                        <div class="dd-item" data-value="ton">Ton</div>
                    </div>
                    <input type="hidden" name="satuan_bibit" id="satuan_bibit" value="{{ old('satuan_bibit', 'kg') }}">
                </div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Tanggal Tanam</label>
                <input type="date" name="tanggal_tanam" value="{{ old('tanggal_tanam') }}">
            </div>
            <div class="form-group">
                <label>Musim Saat Menanam</label>
                <div class="custom-dropdown" id="dd-musim">
                    <button type="button" class="dd-toggle">
                        <span class="dd-label">-- Pilih Musim --</span>
                        <i class="ti ti-chevron-down dd-arrow"></i>
                    </button>
                    <div class="dd-list">
                        <div class="dd-item" data-value="hujan">Musim Hujan</div>
                        <div class="dd-item" data-value="kemarau">Musim Kemarau</div>
                        <div class="dd-item" data-value="pancaroba">Pancaroba</div>
                    </div>
                    <input type="hidden" name="musim" id="musim" value="{{ old('musim') }}">
                </div>
            </div>
        </div>

        <div style="background:#f9fbe7; padding:15px; border-radius:8px; margin-bottom:15px;">
            <p style="font-size:13px; color:#555;">
                Lokasi lahan kamu: <strong>{{ Auth::user()->kecamatan }}, {{ Auth::user()->kabupaten }}</strong><br>
                <small style="color:#999;">Rekomendasi alat di bawah ditampilkan berdasarkan kecamatan ini.</small>
            </p>
        </div>

        <div class="form-group" style="margin-bottom:15px;">
            <label>Rekomendasi Alat yang Bisa Disewa <span style="color:#999; font-weight:normal;">(opsional, tidak wajib disewa)</span></label>

            @if($alatRekomendasi->isEmpty())
                <div style="background:#1a1a1a; border:1px solid #333; border-radius:8px; padding:15px; font-size:13px; color:#999;">
                    Belum ada alat pengolahan tanah/penanaman yang tersedia di kecamatan {{ Auth::user()->kecamatan }} saat ini.
                    <a href="/user/alat" style="color:#4caf50;">Cari alat di kecamatan lain &rarr;</a>
                </div>
            @else
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    @foreach($alatRekomendasi as $alat)
                        <div style="background:#1a1a1a; border:1px solid #2e7d32; border-radius:8px; overflow:hidden;">
                            @if($alat->foto)
                                <img src="{{ asset('storage/' . $alat->foto) }}"
                                    alt="{{ $alat->nama_alat }}"
                                    style="width:100%; height:130px; object-fit:cover;">
                            @else
                                <div style="width:100%; height:130px; background:rgba(46,125,50,0.15); display:flex; align-items:center; justify-content:center;">
                                    <span style="color:rgba(255,255,255,0.3); font-size:12px;">Tidak ada foto</span>
                                </div>
                            @endif
                            <div style="padding:12px 14px;">
                                <div style="display:flex; justify-content:space-between; align-items:start;">
                                    <strong style="color:#fff; font-size:14px;">{{ $alat->nama_alat }}</strong>
                                    <span style="background:#2e4d32; color:#4caf50; font-size:11px; padding:2px 8px; border-radius:10px; white-space:nowrap;">{{ $alat->kategori }}</span>
                                </div>
                                <p style="color:#aaa; font-size:12px; margin:6px 0;">
                                    {{ $alat->kecamatan }}, {{ $alat->kabupaten }} &middot; Pemilik: {{ $alat->mitra->name ?? '-' }}
                                </p>
                                <p style="color:#00e676; font-size:14px; font-weight:600; margin:0;">
                                    Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }} / hari
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="/user/alat" style="display:inline-block; margin-top:10px; font-size:12px; color:#4caf50;">Lihat semua alat tersedia &rarr;</a>
            @endif
        </div>

        <div style="display:flex; gap:10px; margin-top:10px;">
            <button type="submit" class="btn btn-green">Simpan dan Prediksi Modal</button>
            <a href="/user/pra-panen" class="btn btn-gray">Batal</a>
        </div>
    </form>
</div>

<script>
    const tanamanData = @json($tanamanByKategori);

    function initDropdown(id, onSelect) {
        const dd = document.getElementById(id);
        const toggle = dd.querySelector('.dd-toggle');
        const list = dd.querySelector('.dd-list');
        const label = dd.querySelector('.dd-label');
        const hidden = dd.querySelector('input[type=hidden]');

        toggle.addEventListener('click', () => {
            document.querySelectorAll('.dd-list').forEach(l => { if (l !== list) l.style.display = 'none'; });
            const isOpen = list.style.display === 'block';
            list.style.display = isOpen ? 'none' : 'block';
            toggle.classList.toggle('open', !isOpen);
        });

        dd.addEventListener('click', (e) => {
            const item = e.target.closest('.dd-item');
            if (!item || item.classList.contains('muted')) return;
            label.textContent = item.textContent;
            hidden.value = item.dataset.value;
            list.style.display = 'none';
            toggle.classList.remove('open');
            if (onSelect) onSelect(item.dataset.value);
        });

        return { dd, list, label, hidden };
    }

    const ddTanaman = initDropdown('dd-tanaman');

    initDropdown('dd-kategori', function (kategori) {
        const list = ddTanaman.dd.querySelector('.dd-list');
        list.innerHTML = '';
        ddTanaman.label.textContent = '-- Pilih Tanaman --';
        ddTanaman.hidden.value = '';

        if (kategori && tanamanData[kategori]) {
            tanamanData[kategori].forEach(function (item) {
                const div = document.createElement('div');
                div.className = 'dd-item';
                div.dataset.value = item.nama;
                div.textContent = item.nama;
                list.appendChild(div);
            });
        }
    });

    initDropdown('dd-satuan');
    initDropdown('dd-musim');

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.custom-dropdown')) {
            document.querySelectorAll('.dd-list').forEach(l => l.style.display = 'none');
            document.querySelectorAll('.dd-toggle').forEach(t => t.classList.remove('open'));
        }
    });
</script>
@endsection