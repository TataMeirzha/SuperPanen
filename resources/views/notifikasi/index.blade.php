@extends('layouts.app')

@section('title', 'Notifikasi')

@section('sidebar')
    @php $role = Auth::user()->role; @endphp
    @if($role === 'superadmin')
        <div class="menu-label">Menu Utama</div>
        <a href="/superadmin/dashboard">Dashboard</a>
    @elseif($role === 'admin_panen')
        <div class="menu-label">Menu Utama</div>
        <a href="/admin-panen/dashboard">Dashboard</a>
    @elseif($role === 'mitra')
        <div class="menu-label">Menu Utama</div>
        <a href="/mitra/dashboard">Dashboard</a>
    @else
        <div class="menu-label">Menu Utama</div>
        <a href="/user/dashboard">Dashboard</a>
    @endif
    <div class="menu-label">Lainnya</div>
    <a href="/notifikasi" class="active">Semua Notifikasi</a>
@endsection

@section('content')
<div class="page-title">Semua Notifikasi</div>

<div style="display:flex; justify-content:flex-end; margin-bottom:15px;">
    <form action="/notifikasi/baca-semua" method="POST">
        @csrf
        <button type="submit" class="btn btn-gray">Tandai Semua Dibaca</button>
    </form>
</div>

<div class="card">
    @forelse($notifikasi as $item)
    <div style="padding:14px; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center; {{ !$item->dibaca ? 'background:#f9fbe7;' : '' }}">
        <div>
            @if(!$item->dibaca)
                <span class="badge badge-green" style="margin-bottom:5px; font-size:10px;">Baru</span><br>
            @endif
            <strong style="font-size:14px;">{{ $item->judul }}</strong>
            <p style="font-size:13px; color:#555; margin-top:4px;">{{ $item->pesan }}</p>
            <small style="color:#999;">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
        </div>
        @if(!$item->dibaca)
        <a href="/notifikasi/{{ $item->id }}/baca" class="btn btn-green" style="font-size:12px; padding:6px 14px; white-space:nowrap; margin-left:15px;">Baca</a>
        @endif
    </div>
    @empty
    <div style="text-align:center; padding:40px; color:#999;">Tidak ada notifikasi.</div>
    @endforelse
</div>

{{ $notifikasi->links() }}
@endsection