<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PraPanen;
use App\Models\PascaPanen;
use App\Models\PermintaanSewa;
use App\Models\Notifikasi;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        $user = Auth::user();
        $totalPraPanen = PraPanen::where('user_id', $user->id)->count();
        $totalPascaPanen = PascaPanen::where('user_id', $user->id)->count();
        $totalKeuntungan = PascaPanen::where('user_id', $user->id)->sum('keuntungan_bersih');
        $totalSewa = PermintaanSewa::where('user_id', $user->id)->count();
        $recentPraPanen = PraPanen::where('user_id', $user->id)->latest()->take(5)->get();
        $recentSewa = PermintaanSewa::where('user_id', $user->id)->with('alatPertanian')->latest()->take(5)->get();
        $notifikasi = Notifikasi::where('user_id', $user->id)->where('dibaca', false)->latest()->take(5)->get();

        return view('user.dashboard', compact(
            'totalPraPanen', 'totalPascaPanen', 'totalKeuntungan',
            'totalSewa', 'recentPraPanen', 'recentSewa', 'notifikasi'
        ));
    }

    public function mitraDashboard()
    {
        $user = Auth::user();
        $totalAlat = \App\Models\AlatPertanian::where('mitra_id', $user->id)->count();
        $totalPermintaan = PermintaanSewa::whereHas('alatPertanian', fn($q) => $q->where('mitra_id', $user->id))->count();
        $permintaanPending = PermintaanSewa::whereHas('alatPertanian', fn($q) => $q->where('mitra_id', $user->id))->where('status', 'pending')->count();
        $totalPendapatan = PermintaanSewa::whereHas('alatPertanian', fn($q) => $q->where('mitra_id', $user->id))->where('status', 'disetujui')->sum('total_biaya');
        $recentPermintaan = PermintaanSewa::whereHas('alatPertanian', fn($q) => $q->where('mitra_id', $user->id))->with(['user', 'alatPertanian'])->latest()->take(5)->get();
        $notifikasi = Notifikasi::where('user_id', $user->id)->where('dibaca', false)->latest()->take(5)->get();

        return view('mitra.dashboard', compact(
            'totalAlat', 'totalPermintaan', 'permintaanPending',
            'totalPendapatan', 'recentPermintaan', 'notifikasi'
        ));
    }
}