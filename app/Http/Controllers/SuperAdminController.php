<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PraPanen;
use App\Models\PascaPanen;
use App\Models\AlatPertanian;
use App\Models\PermintaanSewa;
use App\Models\Laporan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalUser = User::where('role', 'user')->count();
        $totalMitra = User::where('role', 'mitra')->count();
        $totalPraPanen = PraPanen::count();
        $totalPascaPanen = PascaPanen::count();
        $totalAlat = AlatPertanian::count();
        $totalSewa = PermintaanSewa::count();
        $laporanPending = Laporan::where('status', 'pending')->count();
        $notifikasi = Notifikasi::where('user_id', auth()->id())->where('dibaca', false)->latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalUser', 'totalMitra', 'totalPraPanen',
            'totalPascaPanen', 'totalAlat', 'totalSewa',
            'laporanPending', 'notifikasi'
        ));
    }

    // Kelola User
    public function users()
    {
        $users = User::whereIn('role', ['user', 'mitra'])->latest()->get();
        return view('superadmin.users.index', compact('users'));
    }

    public function toggleUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect('/superadmin/users')->with('success', "User berhasil $status!");
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect('/superadmin/users')->with('success', 'User berhasil dihapus!');
    }

    // Kelola Admin Panen
    public function adminPanen()
    {
        $admins = User::where('role', 'admin_panen')->latest()->get();
        return view('superadmin.admin_panen.index', compact('admins'));
    }

    public function createAdminPanen() { return view('superadmin.admin_panen.create'); }

    public function storeAdminPanen(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'no_hp' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_panen',
            'no_hp' => $request->no_hp,
            'kecamatan' => '-',
            'kabupaten' => '-',
            'provinsi' => '-',
            'is_active' => true,
        ]);

        return redirect('/superadmin/admin-panen')->with('success', 'Admin panen berhasil ditambahkan!');
    }

    public function deleteAdminPanen($id)
    {
        User::where('id', $id)->where('role', 'admin_panen')->firstOrFail()->delete();
        return redirect('/superadmin/admin-panen')->with('success', 'Admin panen berhasil dihapus!');
    }
}