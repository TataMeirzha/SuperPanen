<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AlatPertanian;

class AlatPertanianController extends Controller
{
    // Mitra: lihat alat miliknya
    public function index()
    {
        $alat = AlatPertanian::where('mitra_id', Auth::id())->latest()->get();
        return view('mitra.alat.index', compact('alat'));
    }

    public function create() { return view('mitra.alat.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required',
            'kategori' => 'required',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:1',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
        ]);

        AlatPertanian::create([
            'mitra_id' => Auth::id(),
            'nama_alat' => $request->nama_alat,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'harga_sewa_per_hari' => $request->harga_sewa_per_hari,
            'stok' => $request->stok,
            'status' => 'tersedia',
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
        ]);

        return redirect('/mitra/alat')->with('success', 'Alat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $alat = AlatPertanian::where('id', $id)->where('mitra_id', Auth::id())->firstOrFail();
        return view('mitra.alat.edit', compact('alat'));
    }

    public function update(Request $request, $id)
    {
        $alat = AlatPertanian::where('id', $id)->where('mitra_id', Auth::id())->firstOrFail();
        $alat->update($request->all());
        return redirect('/mitra/alat')->with('success', 'Alat berhasil diupdate!');
    }

    public function destroy($id)
    {
        AlatPertanian::where('id', $id)->where('mitra_id', Auth::id())->firstOrFail()->delete();
        return redirect('/mitra/alat')->with('success', 'Alat berhasil dihapus!');
    }

    // User: cari alat berdasarkan kecamatan
    public function cariAlat(Request $request)
    {
        $user = Auth::user();
        $kecamatan = $request->kecamatan ?? $user->kecamatan;
        $kabupaten = $request->kabupaten ?? $user->kabupaten;

        $alat = AlatPertanian::where('status', 'tersedia')
            ->where(function($q) use ($kecamatan, $kabupaten) {
                $q->where('kecamatan', $kecamatan)
                  ->orWhere('kabupaten', $kabupaten);
            })
            ->with('mitra')
            ->get();

        return view('user.alat.index', compact('alat', 'kecamatan', 'kabupaten'));
    }

    // Halaman pembuktian fragmentasi horizontal (UAS Basis Data)
    public function gabungan()
    {
        // Ambil data dari Server 1 (Madiun) - database lokal
        $dataServer1 = DB::connection('mysql')
            ->table('alat_pertanians')
            ->select('*')
            ->get()
            ->map(function ($item) {
                $item->asal_server = 'Server 1';
                return $item;
            });

        // Ambil data dari Server 2 (luar Madiun) - database PC teman
        $dataServer2 = DB::connection('fragment2')
            ->table('alat_pertanians')
            ->select('*')
            ->get()
            ->map(function ($item) {
                $item->asal_server = 'Server 2';
                return $item;
            });

        // Gabungkan kedua hasil
        $dataGabungan = $dataServer1->concat($dataServer2);

        return view('alat-pertanian.index', [
            'dataGabungan' => $dataGabungan,
            'totalServer1' => $dataServer1->count(),
            'totalServer2' => $dataServer2->count(),
        ]);
    }
}