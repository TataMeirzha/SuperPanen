@extends('layouts.app')

@section('title', 'Tambah Admin Panen')

@section('sidebar')
    <div class="menu-label">Menu Utama</div>
    <a href="/superadmin/dashboard">Dashboard</a>
    <div class="menu-label">Kelola Sistem</div>
    <a href="/superadmin/users">Kelola User</a>
    <a href="/superadmin/admin-panen" class="active">Kelola Admin Panen</a>
    <div class="menu-label">Laporan</div>
    <a href="/superadmin/laporan">Pusat Laporan</a>
@endsection

@section('content')
<div class="page-title">Tambah Admin Panen</div>

@if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="card" style="max-width:600px;">
    <form action="/superadmin/admin-panen/store" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama admin panen">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com">
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Min. 6 karakter">
        </div>
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-green">Simpan</button>
            <a href="/superadmin/admin-panen" class="btn btn-gray">Batal</a>
        </div>
    </form>
</div>
@endsection