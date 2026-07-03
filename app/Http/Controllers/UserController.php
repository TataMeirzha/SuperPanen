<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PraPanen;
use App\Models\PascaPanen;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function praPanenIndex()
    {
        $praPanen = PraPanen::where('user_id', Auth::id())->latest()->get();
        return view('user.pra_panen.index', compact('praPanen'));
    }

    public function praPanenCreate()
    {
        $tanaman = DB::table('tanamanlist')->orderBy('kategori')->orderBy('nama')->get();
        $tanamanByKategori = $tanaman->groupBy('kategori');

        $user = Auth::user();
        $alatRekomendasi = \App\Models\AlatPertanian::where('status', 'tersedia')
            ->whereIn('kategori', ['Pengolahan Tanah', 'Penanaman'])
            ->where(function ($q) use ($user) {
                $q->where('kecamatan', $user->kecamatan)
                  ->orWhere('kabupaten', $user->kabupaten);
            })
            ->with('mitra')
            ->latest()
            ->get();

        return view('user.pra_panen.create', compact('tanamanByKategori', 'alatRekomendasi'));
    }

    public function praPanenStore(Request $request)
    {
        $request->validate([
            'kategori_tanaman' => 'required',
            'nama_tanaman' => 'required',
            'jumlah_bibit' => 'required|numeric|min:0',
            'satuan_bibit' => 'required',
            'tanggal_tanam' => 'required|date',
            'musim' => 'required',
            'alat_pertanian_id' => 'nullable|exists:alat_pertanians,id',
            'tanggal_mulai_sewa' => 'nullable|date|required_with:alat_pertanian_id|after_or_equal:today',
            'tanggal_selesai_sewa' => 'nullable|date|required_with:alat_pertanian_id|after:tanggal_mulai_sewa',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048|required_with:alat_pertanian_id',
        ]);

        $jumlahKg = $request->satuan_bibit === 'ton' ? $request->jumlah_bibit * 1000 : $request->jumlah_bibit;
        $luasLahan = round($jumlahKg * 0.02, 2);
        $estimasiModal = $luasLahan * 5000000;

        $biayaSewaAlat = 0;
        $alat = null;
        $durasiSewa = 0;

        if ($request->filled('alat_pertanian_id')) {
            $alat = \App\Models\AlatPertanian::findOrFail($request->alat_pertanian_id);
            $durasiSewa = \Carbon\Carbon::parse($request->tanggal_mulai_sewa)
                ->diffInDays(\Carbon\Carbon::parse($request->tanggal_selesai_sewa));
            $durasiSewa = max($durasiSewa, 1);
            $biayaSewaAlat = $alat->harga_sewa_per_hari * $durasiSewa;
            $estimasiModal += $biayaSewaAlat;
        }

        $praPanen = PraPanen::create([
            'user_id' => Auth::id(),
            'kategori_tanaman' => $request->kategori_tanaman,
            'nama_tanaman' => $request->nama_tanaman,
            'jumlah_bibit' => $request->jumlah_bibit,
            'satuan_bibit' => $request->satuan_bibit,
            'tanggal_tanam' => $request->tanggal_tanam,
            'musim' => $request->musim,
            'kecamatan' => Auth::user()->kecamatan,
            'kabupaten' => Auth::user()->kabupaten,
            'luas_lahan_rekomendasi' => $luasLahan,
            'estimasi_modal' => $estimasiModal,
            'biaya_sewa_alat' => $biayaSewaAlat,
            'status' => 'aktif',
        ]);

        // Kalau user pilih sewa alat, langsung buat permintaan sewa resmi ke mitra
        if ($alat) {
            $fotoKtpPath = $request->file('foto_ktp')->store('ktp', 'public');

            \App\Models\PermintaanSewa::create([
                'user_id' => Auth::id(),
                'alat_pertanian_id' => $alat->id,
                'pra_panen_id' => $praPanen->id,
                'tanggal_mulai' => $request->tanggal_mulai_sewa,
                'tanggal_selesai' => $request->tanggal_selesai_sewa,
                'durasi_hari' => $durasiSewa,
                'total_biaya' => $biayaSewaAlat,
                'status' => 'pending',
                'catatan_user' => 'Diajukan otomatis saat pencatatan pra panen.',
                'foto_ktp' => $fotoKtpPath,
            ]);

            \App\Models\Notifikasi::create([
                'user_id' => $alat->mitra_id,
                'judul' => 'Permintaan Sewa Baru!',
                'pesan' => Auth::user()->name . ' ingin menyewa ' . $alat->nama_alat . ' selama ' . $durasiSewa . ' hari.',
                'tipe' => 'sewa',
                'url' => '/mitra/permintaan-sewa',
            ]);

            return redirect('/user/pra-panen')->with('success', 'Data pra panen tersimpan & permintaan sewa alat sudah dikirim ke mitra, tinggal tunggu persetujuan!');
        }

        return redirect('/user/pra-panen')->with('success', 'Data pra panen berhasil disimpan!');
    }

    public function pascaPanenIndex()
    {
        $pascaPanen = PascaPanen::where('user_id', Auth::id())->with('praPanen')->latest()->get();
        return view('user.pasca_panen.index', compact('pascaPanen'));
    }

    public function pascaPanenCreate($pra_panen_id)
    {
        $praPanen = PraPanen::where('id', $pra_panen_id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.pasca_panen.create', compact('praPanen'));
    }

    public function pascaPanenStore(Request $request)
    {
        $request->validate([
            'pra_panen_id' => 'required|exists:pra_panens,id',
            'tanggal_panen' => 'required|date',
            'hasil_panen' => 'required|numeric|min:0',
            'satuan_hasil' => 'required',
            'modal_real' => 'required|numeric|min:0',
            'harga_jual_per_kg' => 'required|numeric|min:0',
        ]);

        $hasilKg = $request->satuan_hasil === 'ton' ? $request->hasil_panen * 1000 : $request->hasil_panen;
        $totalPendapatan = $hasilKg * $request->harga_jual_per_kg;
        $keuntungan = $totalPendapatan - $request->modal_real;

        PascaPanen::create([
            'user_id' => Auth::id(),
            'pra_panen_id' => $request->pra_panen_id,
            'tanggal_panen' => $request->tanggal_panen,
            'hasil_panen' => $request->hasil_panen,
            'satuan_hasil' => $request->satuan_hasil,
            'modal_real' => $request->modal_real,
            'harga_jual_per_kg' => $request->harga_jual_per_kg,
            'total_pendapatan' => $totalPendapatan,
            'keuntungan_bersih' => $keuntungan,
            'catatan' => $request->catatan,
        ]);

        PraPanen::where('id', $request->pra_panen_id)->update(['status' => 'selesai']);

        return redirect('/user/pasca-panen')->with('success', 'Data pasca panen berhasil disimpan!');
    }
}