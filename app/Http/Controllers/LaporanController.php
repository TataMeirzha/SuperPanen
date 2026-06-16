<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use App\Models\Notifikasi;
use App\Models\User;

class LaporanController extends Controller
{
    // User & Mitra: kirim laporan
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required|min:20',
        ]);

        Laporan::create([
            'pengirim_id' => Auth::id(),
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        // Notifikasi ke superadmin
        $superadmin = User::where('role', 'superadmin')->first();
        if ($superadmin) {
            Notifikasi::create([
                'user_id' => $superadmin->id,
                'judul' => 'Laporan Baru Masuk!',
                'pesan' => Auth::user()->name . ' mengirim laporan: ' . $request->judul,
                'tipe' => 'laporan',
                'url' => '/superadmin/laporan',
            ]);
        }

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    // User & Mitra: lihat laporan mereka
    public function index()
    {
        $laporan = Laporan::where('pengirim_id', Auth::id())->latest()->get();
        $role = Auth::user()->role;
        $view = $role === 'mitra' ? 'mitra.laporan.index' : 'user.laporan.index';
        return view($view, compact('laporan'));
    }

    public function create()
    {
        $role = Auth::user()->role;
        $view = $role === 'mitra' ? 'mitra.laporan.create' : 'user.laporan.create';
        return view($view);
    }

    // Superadmin: lihat semua laporan
    public function adminIndex()
    {
        $laporan = Laporan::with('pengirim')->latest()->get();
        return view('superadmin.laporan.index', compact('laporan'));
    }

    // Superadmin: balas laporan
    public function balas(Request $request, $id)
    {
        $request->validate(['balasan' => 'required|min:5']);

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'balasan' => $request->balasan,
            'status' => 'selesai',
            'dibalas_oleh' => Auth::id(),
            'dibalas_at' => now(),
        ]);

        // Notifikasi ke pengirim
        Notifikasi::create([
            'user_id' => $laporan->pengirim_id,
            'judul' => 'Laporan Kamu Telah Dibalas!',
            'pesan' => 'Admin telah membalas laporan kamu: ' . $laporan->judul,
            'tipe' => 'laporan',
            'url' => Auth::user()->role === 'mitra' ? '/mitra/laporan' : '/user/laporan',
        ]);

        return redirect('/superadmin/laporan')->with('success', 'Laporan berhasil dibalas!');
    }
}