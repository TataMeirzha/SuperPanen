<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())->latest()->paginate(15);
        return view('notifikasi.index', compact('notifikasi'));
    }

    public function baca($id)
    {
        Notifikasi::where('id', $id)->where('user_id', Auth::id())->update(['dibaca' => true]);
        $notif = Notifikasi::find($id);
        return redirect($notif->url ?? '/user/dashboard');
    }

    public function bacaSemua()
    {
        Notifikasi::where('user_id', Auth::id())->update(['dibaca' => true]);
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca!');
    }
}