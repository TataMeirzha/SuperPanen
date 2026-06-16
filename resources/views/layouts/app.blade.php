<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperPanen - @yield('title')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('/images/bg-dashboard.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Overlay gelap agar konten tetap terbaca */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 0;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(27, 94, 32, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 14px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 2px 12px rgba(0,0,0,0.2);
        }
        .navbar .logo { color: white; font-size: 20px; font-weight: bold; text-decoration: none; letter-spacing: 1px; }
        .navbar .badge { background: rgba(255,255,255,0.2); color: white; padding: 3px 10px; border-radius: 10px; font-size: 11px; margin-left: 8px; }
        .navbar .right { display: flex; align-items: center; gap: 15px; }
        .navbar .user-name { background: rgba(255,255,255,0.15); color: white; padding: 6px 14px; border-radius: 20px; font-size: 13px; }
        .notif-btn { position: relative; color: white; text-decoration: none; font-size: 18px; }
        .notif-badge { position: absolute; top: -5px; right: -8px; background: #e53935; color: white; border-radius: 50%; width: 16px; height: 16px; font-size: 10px; display: flex; align-items: center; justify-content: center; }
        .btn-logout { background: rgba(198,40,40,0.8); color: white; border: none; padding: 7px 18px; border-radius: 20px; cursor: pointer; font-size: 13px; transition: background 0.2s; }
        .btn-logout:hover { background: #b71c1c; }

        /* WRAPPER */
        .wrapper { display: flex; margin-top: 55px; min-height: calc(100vh - 55px); position: relative; z-index: 1; }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            min-height: 100%;
            position: fixed;
            top: 55px; left: 0; bottom: 0;
            overflow-y: auto;
            padding-top: 20px;
            border-right: 1px solid rgba(255,255,255,0.15);
        }
        .sidebar .menu-label { color: rgba(255,255,255,0.55); font-size: 10px; text-transform: uppercase; padding: 12px 20px 5px; letter-spacing: 1.5px; }
        .sidebar a { display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,0.8); text-decoration: none; padding: 11px 20px; font-size: 14px; transition: all 0.2s; border-left: 3px solid transparent; }
        .sidebar a:hover { background: rgba(255,255,255,0.12); color: white; border-left: 3px solid rgba(255,255,255,0.5); }
        .sidebar a.active { background: rgba(255,255,255,0.18); color: white; border-left: 3px solid #a5d6a7; font-weight: bold; }

        /* MAIN CONTENT */
        .main-content { margin-left: 230px; flex: 1; padding: 28px; }

        .page-title { font-size: 22px; color: white; margin-bottom: 22px; font-weight: bold; text-shadow: 0 1px 4px rgba(0,0,0,0.5); border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 10px; }

        /* ALERT */
        .alert-success { background: rgba(46,125,50,0.7); backdrop-filter: blur(8px); border: 1px solid rgba(165,214,167,0.5); color: white; padding: 12px 16px; border-radius: 10px; margin-bottom: 15px; }
        .alert-error { background: rgba(198,40,40,0.7); backdrop-filter: blur(8px); border: 1px solid rgba(239,154,154,0.5); color: white; padding: 12px 16px; border-radius: 10px; margin-bottom: 15px; }
        .alert-info { background: rgba(21,101,192,0.7); backdrop-filter: blur(8px); border: 1px solid rgba(144,202,249,0.5); color: white; padding: 12px 16px; border-radius: 10px; margin-bottom: 15px; }
        .alert-info a { color: #90caf9; font-weight: bold; }

        /* CARD */
        .card {
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.2);
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .card h3 { color: white; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; }
        th { background: rgba(27, 94, 32, 0.9); color: white; padding: 11px 12px; text-align: left; font-size: 13px; }
        th:first-child { border-radius: 6px 0 0 0; }
        th:last-child { border-radius: 0 6px 0 0; }
        td { padding: 10px 12px; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 13px; color: white; }
        tr:hover td { background: rgba(46,125,50,0.15); }

        /* BUTTON */
        .btn { padding: 8px 18px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; text-decoration: none; display: inline-block; transition: all 0.2s; }
        .btn-green { background: rgba(46,125,50,0.85); color: white; }
        .btn-green:hover { background: #1b5e20; }
        .btn-blue { background: rgba(21,101,192,0.85); color: white; }
        .btn-blue:hover { background: #0d47a1; }
        .btn-red { background: rgba(198,40,40,0.85); color: white; }
        .btn-red:hover { background: #b71c1c; }
        .btn-orange { background: rgba(230,81,0,0.85); color: white; }
        .btn-orange:hover { background: #bf360c; }
        .btn-gray { background: rgba(117,117,117,0.85); color: white; }
        .btn-gray:hover { background: #616161; }

        /* FORM */
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; color: rgba(255,255,255,0.9); font-size: 14px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 10px 14px;
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 8px; font-size: 14px; outline: none;
            background: rgba(0, 0, 0, 0.35);
            color: white;
            transition: border 0.2s;
        }
        .form-group input::placeholder, .form-group textarea::placeholder { color: rgba(255,255,255,0.45); }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #a5d6a7; background: rgba(255,255,255,0.2); }
        .form-group select option { background: #1b5e20; color: white; }
        .form-group small { color: rgba(255,255,255,0.6); font-size:12px; }

        /* STAT CARDS */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 22px; }
        .stat-card {
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            border-left: 5px solid #4caf50;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        .stat-card .stat-number { font-size: 26px; font-weight: bold; color: white; }
        .stat-card .stat-label { font-size: 13px; color: rgba(255,255,255,0.7); margin-top: 5px; }

        /* BADGE */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .badge-green { background: rgba(46,125,50,0.6); color: #a5d6a7; border: 1px solid rgba(165,214,167,0.4); }
        .badge-orange { background: rgba(230,81,0,0.5); color: #ffcc80; border: 1px solid rgba(255,204,128,0.4); }
        .badge-red { background: rgba(198,40,40,0.5); color: #ef9a9a; border: 1px solid rgba(239,154,154,0.4); }
        .badge-blue { background: rgba(21,101,192,0.5); color: #90caf9; border: 1px solid rgba(144,202,249,0.4); }
        .badge-gray { background: rgba(117,117,117,0.5); color: #e0e0e0; border: 1px solid rgba(224,224,224,0.3); }
    </style>
</head>
<body>
    <nav class="navbar">
        <div style="display:flex; align-items:center;">
            <a href="#" class="logo">SuperPanen</a>
            <span class="badge">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
        </div>
        <div class="right">
            @php $notifCount = \App\Models\Notifikasi::where('user_id', Auth::id())->where('dibaca', false)->count(); @endphp
            <a href="/notifikasi" class="notif-btn">
                &#128276;
                @if($notifCount > 0)
                    <span class="notif-badge">{{ $notifCount }}</span>
                @endif
            </a>
            <span class="user-name">{{ Auth::user()->name }}</span>
            <form action="/logout" method="POST" style="margin:0">
                @csrf
                <button type="submit" class="btn-logout">Keluar</button>
            </form>
        </div>
    </nav>

    <div class="wrapper">
        <div class="sidebar">
            @yield('sidebar')
        </div>
        <div class="main-content">
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html>