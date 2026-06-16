<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PraPanen;
use App\Models\PascaPanen;
use App\Models\User;

class AdminPanenController extends Controller
{
    public function dashboard()
    {
        $totalPraPanen = PraPanen::count();
        $totalPascaPanen = PascaPanen::count();
        $totalUser = User::where('role', 'user')->count();
        $totalKeuntungan = PascaPanen::sum('keuntungan_bersih');
        $recentPraPanen = PraPanen::with('user')->latest()->take(10)->get();

        return view('admin_panen.dashboard', compact(
            'totalPraPanen', 'totalPascaPanen',
            'totalUser', 'totalKeuntungan', 'recentPraPanen'
        ));
    }

    public function praPanen()
    {
        $praPanen = PraPanen::with('user')->latest()->get();
        return view('admin_panen.pra_panen.index', compact('praPanen'));
    }

    public function pascaPanen()
    {
        $pascaPanen = PascaPanen::with(['user', 'praPanen'])->latest()->get();
        return view('admin_panen.pasca_panen.index', compact('pascaPanen'));
    }

    public function deletePraPanen($id)
    {
        PraPanen::findOrFail($id)->delete();
        return redirect('/admin-panen/pra-panen')->with('success', 'Data berhasil dihapus!');
    }

    public function deletePascaPanen($id)
    {
        PascaPanen::findOrFail($id)->delete();
        return redirect('/admin-panen/pasca-panen')->with('success', 'Data berhasil dihapus!');
    }
}