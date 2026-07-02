<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('alat', 'public');
        }

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
            'foto' => $fotoPath,
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

        $request->validate([
            'nama_alat' => 'required',
            'kategori' => 'required',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:1',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = $alat->foto; // default pakai foto lama

        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage kalau ada
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('alat', 'public');
        }

        $alat->update([
            'nama_alat' => $request->nama_alat,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'harga_sewa_per_hari' => $request->harga_sewa_per_hari,
            'stok' => $request->stok,
            'status' => $request->status,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'foto' => $fotoPath,
        ]);

        return redirect('/mitra/alat')->with('success', 'Alat berhasil diupdate!');
    }

    public function destroy($id)
    {
        $alat = AlatPertanian::where('id', $id)->where('mitra_id', Auth::id())->firstOrFail();

        // Hapus foto dari storage saat alat dihapus
        if ($alat->foto) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();
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
        $dataServer1 = DB::connection('mysql')
            ->table('alat_pertanians')
            ->select('*')
            ->get()
            ->map(function ($item) {
                $item->asal_server = 'Server 1';
                return $item;
            });

        $dataServer2 = DB::connection('fragment2')
            ->table('alat_pertanians')
            ->select('*')
            ->get()
            ->map(function ($item) {
                $item->asal_server = 'Server 2';
                return $item;
            });

        $dataGabungan = $dataServer1->concat($dataServer2);

        return view('alat-pertanian.index', [
            'dataGabungan' => $dataGabungan,
            'totalServer1' => $dataServer1->count(),
            'totalServer2' => $dataServer2->count(),
        ]);
    }
}