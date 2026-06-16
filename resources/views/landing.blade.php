<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperPanen - Sistem Informasi Pertanian</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        nav {
            background: #2e7d32;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        nav .logo { color: white; font-size: 22px; font-weight: bold; text-decoration: none; }
        nav .btn-group a { text-decoration: none; padding: 8px 22px; border-radius: 20px; font-size: 14px; margin-left: 10px; transition: all 0.2s; }
        nav .btn-login { background: white; color: #2e7d32; font-weight: bold; }
        nav .btn-login:hover { background: #f1f8e9; }
        nav .btn-daftar { background: transparent; color: white; border: 2px solid white; }
        nav .btn-daftar:hover { background: rgba(255,255,255,0.1); }

        .hero {
            background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('/images/hero.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: scroll;
            text-align: center;
            padding: 180px 20px 120px;
            color: white;
            margin-top: 55px;
        }
        .hero h1 { font-size: 52px; margin-bottom: 20px; text-shadow: 0 2px 8px rgba(0,0,0,0.4); }
        .hero p { font-size: 18px; opacity: 0.9; max-width: 600px; margin: 0 auto 40px; }
        .hero .btn-mulai { background: #4caf50; color: white; padding: 14px 45px; border-radius: 30px; text-decoration: none; font-size: 16px; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,0,0.3); transition: all 0.2s; display: inline-block; }
        .hero .btn-mulai:hover { background: #388e3c; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.4); }

        .fitur { padding: 80px 60px; text-align: center; background: white; }
        .fitur h2 { font-size: 32px; color: #2e7d32; margin-bottom: 10px; }
        .fitur .subtitle { color: #888; margin-bottom: 50px; font-size: 15px; }
        .fitur-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 30px; max-width: 1100px; margin: 0 auto; }
        .fitur-card { background: white; border-radius: 16px; padding: 35px 25px; border-top: 5px solid #4caf50; box-shadow: 0 8px 30px rgba(0,0,0,0.10); transition: transform 0.2s, box-shadow 0.2s; }
        .fitur-card:hover { transform: translateY(-8px); box-shadow: 0 16px 40px rgba(0,0,0,0.15); }
        .fitur-card h3 { color: #2e7d32; margin-bottom: 10px; font-size: 17px; }
        .fitur-card p { color: #666; font-size: 14px; line-height: 1.6; }

        .role-section { padding: 80px 60px; background: #f5f5f5; text-align: center; }
        .role-section h2 { font-size: 32px; color: #2e7d32; margin-bottom: 10px; }
        .role-section .subtitle { color: #888; margin-bottom: 50px; font-size: 15px; }
        .role-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 30px; max-width: 1100px; margin: 0 auto; }
        .role-card { background: white; border-radius: 16px; padding: 35px 25px; box-shadow: 0 8px 30px rgba(0,0,0,0.10); transition: transform 0.2s, box-shadow 0.2s; border-bottom: 4px solid #2e7d32; }
        .role-card:hover { transform: translateY(-8px); box-shadow: 0 16px 40px rgba(0,0,0,0.15); }
        .role-card h3 { color: #1b5e20; margin-bottom: 10px; font-size: 18px; }
        .role-card p { color: #666; font-size: 13px; line-height: 1.7; }

        .cta { padding: 80px 40px; background: linear-gradient(135deg, #1b5e20, #2e7d32); text-align: center; color: white; }
        .cta h2 { font-size: 32px; margin-bottom: 15px; }
        .cta p { font-size: 16px; opacity: 0.9; margin-bottom: 30px; }
        .cta a { background: white; color: #2e7d32; padding: 13px 40px; border-radius: 30px; text-decoration: none; font-weight: bold; font-size: 15px; transition: all 0.2s; display: inline-block; }
        .cta a:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.2); }

        footer { background: #1b5e20; color: rgba(255,255,255,0.8); text-align: center; padding: 25px; font-size: 14px; }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="logo">SuperPanen</a>
        <div class="btn-group">
            <a href="/register" class="btn-daftar">Daftar</a>
            <a href="/login" class="btn-login">Login</a>
        </div>
    </nav>

    <div class="hero">
        <h1>SuperPanen</h1>
        <p>Platform pertanian digital — catat panen, sewa alat, dan kelola usaha tani kamu dengan mudah dan efisien.</p>
        <a href="/register" class="btn-mulai">Mulai Sekarang</a>
    </div>

    <div class="fitur">
        <h2>Fitur Unggulan</h2>
        <p class="subtitle">Semua yang kamu butuhkan dalam satu platform</p>
        <div class="fitur-grid">
            <div class="fitur-card">
                <h3>Catat Pra Panen</h3>
                <p>Input data tanaman, bibit, dan dapatkan estimasi lahan serta modal secara otomatis.</p>
            </div>
            <div class="fitur-card">
                <h3>Sewa Alat Tani</h3>
                <p>Temukan alat pertanian terdekat berdasarkan kecamatanmu dan sewa dengan mudah.</p>
            </div>
            <div class="fitur-card">
                <h3>Catat Pasca Panen</h3>
                <p>Input hasil panen dan hitung keuntungan bersih secara otomatis.</p>
            </div>
            <div class="fitur-card">
                <h3>Laporan dan Pengaduan</h3>
                <p>Kirim laporan masalah dan dapatkan respon langsung dari admin.</p>
            </div>
        </div>
    </div>

    <div class="role-section">
        <h2>Untuk Siapa SuperPanen?</h2>
        <p class="subtitle">Platform ini dirancang untuk semua pihak dalam ekosistem pertanian</p>
        <div class="role-grid">
            <div class="role-card">
                <h3>Petani</h3>
                <p>Catat data panen, sewa alat terdekat, dan pantau keuntungan usaha tanimu dengan mudah.</p>
            </div>
            <div class="role-card">
                <h3>Mitra Alat</h3>
                <p>Daftarkan alat pertanianmu, atur harga sewa, dan kelola permintaan dari petani sekitar.</p>
            </div>
            <div class="role-card">
                <h3>Admin Panen</h3>
                <p>Pantau dan kelola seluruh data panen dari semua petani yang terdaftar di platform.</p>
            </div>
            <div class="role-card">
                <h3>Super Admin</h3>
                <p>Kelola seluruh sistem, user, mitra, dan tangani laporan pengaduan dari semua pihak.</p>
            </div>
        </div>
    </div>

    <div class="cta">
        <h2>Siap Bergabung?</h2>
        <p>Daftar sekarang dan mulai kelola pertanianmu dengan lebih cerdas.</p>
        <a href="/register">Daftar Gratis</a>
    </div>

    <footer>
        <p>&copy; 2026 SuperPanen. Semua hak dilindungi.</p>
    </footer>
</body>
</html>