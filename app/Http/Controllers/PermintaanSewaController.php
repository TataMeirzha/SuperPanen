<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermintaanSewa;
use App\Models\AlatPertanian;
use App\Models\PraPanen;
use App\Models\Notifikasi;

class PermintaanSewaController extends Controller
{
    // User: buat permintaan sewa
    public function store(Request $request)
    {
        $request->validate([
            'alat_pertanian_id' => 'required|exists:alat_pertanians,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'pra_panen_id' => 'nullable|exists:pra_panens,id',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $alat = AlatPertanian::findOrFail($request->alat_pertanian_id);
        $durasi = \Carbon\Carbon::parse($request->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($request->tanggal_selesai));
        $totalBiaya = $alat->harga_sewa_per_hari * $durasi;

        // Simpan foto KTP
        $fotoKtpPath = $request->file('foto_ktp')->store('ktp', 'public');

        $sewa = PermintaanSewa::create([
            'user_id' => Auth::id(),
            'alat_pertanian_id' => $request->alat_pertanian_id,
            'pra_panen_id' => $request->pra_panen_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi_hari' => $durasi,
            'total_biaya' => $totalBiaya,
            'status' => 'pending',
            'catatan_user' => $request->catatan_user,
            'foto_ktp' => $fotoKtpPath,
        ]);

        // Notifikasi ke mitra
        Notifikasi::create([
            'user_id' => $alat->mitra_id,
            'judul' => 'Permintaan Sewa Baru!',
            'pesan' => Auth::user()->name . ' ingin menyewa ' . $alat->nama_alat . ' selama ' . $durasi . ' hari.',
            'tipe' => 'sewa',
            'url' => '/mitra/permintaan-sewa',
        ]);

        return redirect('/user/permintaan-sewa')->with('success', 'Permintaan sewa berhasil dikirim!');
    }

    // User: lihat permintaan sewanya
    public function userIndex()
    {
        $permintaan = PermintaanSewa::where('user_id', Auth::id())->with(['alatPertanian', 'alatPertanian.mitra'])->latest()->get();
        return view('user.sewa.index', compact('permintaan'));
    }

    // Mitra: lihat permintaan sewa untuk alatnya
    public function mitraIndex()
    {
        $permintaan = PermintaanSewa::whereHas('alatPertanian', fn($q) => $q->where('mitra_id', Auth::id()))
            ->with(['user', 'alatPertanian'])->latest()->get();
        return view('mitra.sewa.index', compact('permintaan'));
    }

    // Mitra: approve/tolak
    public function updateStatus(Request $request, $id)
    {
        $permintaan = PermintaanSewa::whereHas('alatPertanian', fn($q) => $q->where('mitra_id', Auth::id()))
            ->findOrFail($id);

        $permintaan->update([
            'status' => $request->status,
            'catatan_mitra' => $request->catatan_mitra,
        ]);

        // Update status alat jika disetujui
        if ($request->status === 'disetujui') {
            $permintaan->alatPertanian->update(['status' => 'disewa']);
        } elseif ($request->status === 'selesai') {
            $permintaan->alatPertanian->update(['status' => 'tersedia']);
        }

        // Notifikasi ke user
        $pesan = $request->status === 'disetujui'
            ? 'Permintaan sewa kamu disetujui oleh mitra!'
            : 'Permintaan sewa kamu ' . $request->status . '.';

        Notifikasi::create([
            'user_id' => $permintaan->user_id,
            'judul' => 'Update Status Sewa',
            'pesan' => $pesan,
            'tipe' => 'sewa',
            'url' => '/user/permintaan-sewa',
        ]);

        return redirect('/mitra/permintaan-sewa')->with('success', 'Status berhasil diupdate!');
    }
}