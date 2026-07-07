@extends('layouts.app')

@section('title', 'Laporan Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/user/dashboard">Dashboard</a>
    <div class="menu-label">Pencatatan Panen</div>
    <a href="/user/pra-panen">Pra Panen</a>
    <a href="/user/pasca-panen">Pasca Panen</a>
    <div class="menu-label">Sewa Alat</div>
    <a href="/user/alat">Cari Alat Tani</a>
    <a href="/user/permintaan-sewa">Permintaan Sewa Saya</a>
    <div class="menu-label">Laporan</div>
    <a href="/user/laporan-panen" class="active">Laporan Hasil Panen</a>
    <div class="menu-label">Bantuan</div>
    <a href="/user/laporan">Laporan Saya</a>
@endsection

@section('content')
<style>
    .laba-rugi-grid { display: grid; grid-template-columns: 1fr 300px; gap: 16px; }
    .stat-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card-4 { background: rgba(255,255,255,0.07); border-radius: 12px; padding: 18px; border-left: 5px solid #4caf50; }
    .stat-card-4.rugi { border-left-color: #e53935; }
    .stat-card-4.netral { border-left-color: #888; }
    .stat-num { font-size: 20px; font-weight: bold; color: white; margin-bottom: 5px; }
    .stat-num.laba { color: #4caf50; }
    .stat-num.rugi { color: #e53935; }
    .stat-lbl { font-size: 12px; color: rgba(255,255,255,0.5); }
    .ringkasan-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 13px; }
    .ringkasan-row:last-child { border-bottom: none; font-weight: bold; font-size: 14px; padding-top: 12px; }
    .r-label { color: rgba(255,255,255,0.55); }
    .r-val { color: white; }
    .r-val.laba { color: #4caf50; }
    .r-val.rugi { color: #e53935; }
    .progress-bar { height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; margin-top: 5px; }
    .progress-fill { height: 100%; border-radius: 3px; background: #4caf50; }
    .progress-fill.rugi { background: #e53935; }
    .detail-btn { background: rgba(76,175,80,0.15); color: #4caf50; border: 1px solid rgba(76,175,80,0.3); padding: 5px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; text-decoration: none; display: inline-block; }
    .detail-btn.pasca { background: rgba(21,101,192,0.15); color: #90caf9; border-color: rgba(21,101,192,0.3); }
    .filter-row { display: flex; gap: 10px; align-items: center; margin-bottom: 15px; flex-wrap: wrap; }
    .filter-row label { color: rgba(255,255,255,0.5); font-size: 13px; }
    .filter-row select { background: rgba(255,255,255,0.08); border: 1px solid rgba(76,175,80,0.3); color: white; font-size: 13px; padding: 7px 12px; border-radius: 6px; outline: none; }
</style>

<div class="page-title">Laporan Hasil Panen — Laba Rugi</div>

{{-- STAT CARDS --}}
<div class="stat-grid-4">
    <div class="stat-card-4">
        <div class="stat-num">{{ $siklus->count() }}</div>
        <div class="stat-lbl">Total Siklus Panen</div>
    </div>
    <div class="stat-card-4">
        <div class="stat-num laba">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
        <div class="stat-lbl">Total Keuntungan</div>
    </div>
    <div class="stat-card-4 rugi">
        <div class="stat-num rugi">Rp {{ number_format($totalKerugian, 0, ',', '.') }}</div>
        <div class="stat-lbl">Total Kerugian</div>
    </div>
    <div class="stat-card-4 netral">
        <div class="stat-num" style="font-size:14px;">
            {{ $siklus->where('status','laba')->count() }} Laba /
            {{ $siklus->where('status','rugi')->count() }} Rugi /
            {{ $siklus->where('status','aktif')->count() }} Aktif
        </div>
        <div class="stat-lbl">Status Siklus</div>
    </div>
</div>

<div class="laba-rugi-grid">

    {{-- TABEL RIWAYAT --}}
    <div>
        <div class="card">
            <h3 style="color:rgba(255,255,255,0.9); margin-bottom:14px; font-size:14px;">Riwayat Siklus Panen</h3>

            <div class="filter-row">
                <label>Filter:</label>
                <select id="filter-status" onchange="filterTabel()">
                    <option value="semua">Semua Status</option>
                    <option value="laba">Laba</option>
                    <option value="rugi">Rugi</option>
                    <option value="aktif">Aktif</option>
                </select>
            </div>

            <table id="tabel-panen">
                <thead>
                    <tr>
                        <th>Tanaman</th>
                        <th>Tgl Tanam</th>
                        <th>Tgl Panen</th>
                        <th>Modal Real</th>
                        <th>Pendapatan</th>
                        <th>Laba / Rugi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siklus as $item)
                    <tr data-status="{{ $item['status'] }}">
                        <td>
                            <strong>{{ $item['nama_tanaman'] }}</strong><br>
                            <small style="color:rgba(255,255,255,0.45);">{{ $item['kategori_tanaman'] }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item['tanggal_tanam'])->format('d M Y') }}</td>
                        <td>
                            @if($item['tanggal_panen'])
                                {{ \Carbon\Carbon::parse($item['tanggal_panen'])->format('d M Y') }}
                            @else
                                <span style="color:rgba(255,255,255,0.3);">Belum panen</span>
                            @endif
                        </td>
                        <td>
                            @if($item['modal_real'])
                                Rp {{ number_format($item['modal_real'], 0, ',', '.') }}
                            @else
                                <span style="color:rgba(255,255,255,0.3);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($item['total_pendapatan'])
                                Rp {{ number_format($item['total_pendapatan'], 0, ',', '.') }}
                            @else
                                <span style="color:rgba(255,255,255,0.3);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($item['keuntungan_bersih'] !== null)
                                @if($item['keuntungan_bersih'] >= 0)
                                    <span style="color:#4caf50; font-weight:bold;">+Rp {{ number_format($item['keuntungan_bersih'], 0, ',', '.') }}</span>
                                @else
                                    <span style="color:#e53935; font-weight:bold;">-Rp {{ number_format(abs($item['keuntungan_bersih']), 0, ',', '.') }}</span>
                                @endif
                            @else
                                <span style="color:#ff9800; font-size:12px;">Est. Rp {{ number_format($item['estimasi_modal'] * 1.5, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($item['status'] === 'laba')
                                <span class="badge badge-green">Laba</span>
                            @elseif($item['status'] === 'rugi')
                                <span class="badge badge-red">Rugi</span>
                            @else
                                <span class="badge badge-orange">Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if($item['status'] === 'aktif')
                                <a href="/user/pasca-panen/create/{{ $item['pra_panen_id'] }}" class="detail-btn pasca">Input Pasca Panen</a>
                            @else
                                <button onclick="toggleDetail({{ $item['id'] }})" class="detail-btn">Detail</button>
                            @endif
                        </td>
                    </tr>

                    {{-- BARIS DETAIL (tersembunyi) --}}
                    @if($item['status'] !== 'aktif')
                    <tr id="detail-{{ $item['id'] }}" style="display:none; background:rgba(46,125,50,0.05);">
                        <td colspan="8" style="padding:14px 16px;">
                            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px;">
                                <div>
                                    <div style="color:rgba(255,255,255,0.45); font-size:12px; margin-bottom:4px;">Hasil Panen</div>
                                    <div style="color:white; font-size:13px;">{{ $item['hasil_panen'] }} {{ $item['satuan_hasil'] }}</div>
                                </div>
                                <div>
                                    <div style="color:rgba(255,255,255,0.45); font-size:12px; margin-bottom:4px;">Estimasi Modal Awal</div>
                                    <div style="color:white; font-size:13px;">Rp {{ number_format($item['estimasi_modal'], 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div style="color:rgba(255,255,255,0.45); font-size:12px; margin-bottom:4px;">Biaya Sewa Alat</div>
                                    <div style="color:white; font-size:13px;">Rp {{ number_format($item['biaya_sewa'], 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div style="color:rgba(255,255,255,0.45); font-size:12px; margin-bottom:4px;">Luas Lahan</div>
                                    <div style="color:white; font-size:13px;">{{ $item['luas_lahan'] }} Ha</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; color:rgba(255,255,255,0.3); padding:30px;">
                            Belum ada data panen. <a href="/user/pra-panen/create" style="color:#4caf50;">Tambah pra panen sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SIDEBAR KANAN --}}
    <div>
        {{-- Ringkasan Keuangan --}}
        <div class="card" style="margin-bottom:16px;">
            <h3 style="color:rgba(255,255,255,0.9); margin-bottom:14px; font-size:14px;">Ringkasan Keuangan</h3>
            <div class="ringkasan-row">
                <span class="r-label">Total Pendapatan</span>
                <span class="r-val">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
            <div class="ringkasan-row">
                <span class="r-label">Total Modal Real</span>
                <span class="r-val">Rp {{ number_format($totalModal, 0, ',', '.') }}</span>
            </div>
            <div class="ringkasan-row">
                <span class="r-label">Biaya Sewa Alat</span>
                <span class="r-val">Rp {{ number_format($totalSewa, 0, ',', '.') }}</span>
            </div>
            <div class="ringkasan-row">
                <span class="r-label">Keuntungan Bersih</span>
                @php $netTotal = $totalKeuntungan - $totalKerugian; @endphp
                <span class="r-val {{ $netTotal >= 0 ? 'laba' : 'rugi' }}">
                    {{ $netTotal >= 0 ? '+' : '-' }}Rp {{ number_format(abs($netTotal), 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Performa per Tanaman --}}
        @if($perTanaman->count() > 0)
        <div class="card" style="margin-bottom:16px;">
            <h3 style="color:rgba(255,255,255,0.9); margin-bottom:14px; font-size:14px;">Performa per Tanaman</h3>
            @php $maxVal = $perTanaman->max(fn($t) => abs($t['total_laba_rugi'])); @endphp
            @foreach($perTanaman as $t)
            <div style="margin-bottom:12px;">
                <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:5px;">
                    <span style="color:rgba(255,255,255,0.7);">{{ $t['nama'] }}</span>
                    <span style="{{ $t['total_laba_rugi'] >= 0 ? 'color:#4caf50' : 'color:#e53935' }}; font-weight:bold;">
                        {{ $t['total_laba_rugi'] >= 0 ? '+' : '' }}Rp {{ number_format($t['total_laba_rugi'], 0, ',', '.') }}
                    </span>
                </div>
                <div class="progress-bar">
                    <div class="{{ $t['total_laba_rugi'] >= 0 ? 'progress-fill' : 'progress-fill rugi' }}"
                        style="width:{{ $maxVal > 0 ? round(abs($t['total_laba_rugi']) / $maxVal * 100) : 0 }}%">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Siklus Aktif --}}
        @php $aktif = $siklus->where('status', 'aktif')->first(); @endphp
        @if($aktif)
        <div class="card">
            <h3 style="color:rgba(255,255,255,0.9); margin-bottom:8px; font-size:14px;">Siklus Aktif</h3>
            <div style="font-size:12px; color:rgba(255,255,255,0.5); margin-bottom:12px;">
                {{ $aktif['nama_tanaman'] }} — ditanam {{ \Carbon\Carbon::parse($aktif['tanggal_tanam'])->format('d M Y') }}
            </div>
            <div class="ringkasan-row">
                <span class="r-label">Estimasi modal</span>
                <span class="r-val">Rp {{ number_format($aktif['estimasi_modal'], 0, ',', '.') }}</span>
            </div>
            <div class="ringkasan-row">
                <span class="r-label">Luas lahan</span>
                <span class="r-val">{{ $aktif['luas_lahan'] }} Ha</span>
            </div>
            <a href="/user/pasca-panen/create/{{ $aktif['pra_panen_id'] }}"
               class="btn btn-green" style="width:100%; text-align:center; margin-top:12px; display:block;">
                Input Data Pasca Panen
            </a>
        </div>
        @endif
    </div>

</div>

<script>
function toggleDetail(id) {
    const row = document.getElementById('detail-' + id);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}

function filterTabel() {
    const val = document.getElementById('filter-status').value;
    document.querySelectorAll('#tabel-panen tbody tr[data-status]').forEach(row => {
        if (val === 'semua' || row.dataset.status === val) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
            const detailId = row.querySelector('[onclick]')?.getAttribute('onclick')?.match(/\d+/)?.[0];
            if (detailId) {
                const detailRow = document.getElementById('detail-' + detailId);
                if (detailRow) detailRow.style.display = 'none';
            }
        }
    });
}
</script>
@endsection