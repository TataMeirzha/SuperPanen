<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperPanen - Sistem Informasi Pertanian</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body {
            background: #0a0a0a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR */
        nav {
            background: #0a0a0a;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        nav .logo { color: white; font-size: 22px; font-weight: bold; text-decoration: none; }
        nav .btn-group a { text-decoration: none; padding: 8px 22px; border-radius: 20px; font-size: 14px; margin-left: 10px; transition: all 0.2s; }
        nav .btn-login { background: #1b5e20; color: white; font-weight: bold; }
        nav .btn-login:hover { background: #2e7d32; }
        nav .btn-daftar { background: transparent; color: #4caf50; border: 2px solid #4caf50; }
        nav .btn-daftar:hover { background: rgba(76,175,80,0.1); }

        /* WRAPPER UTAMA - semua dibungkus jadi 1 */
        .main-wrapper {
            margin-top: 55px;
            width: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* HERO */
        .hero {
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/images/hero.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: clamp(60px, 12vw, 150px) clamp(15px, 5vw, 40px);
            color: white;
            width: 100%;
        }
        .hero h1 { font-size: clamp(24px, 5vw, 52px); margin-bottom: 15px; text-shadow: 0 2px 8px rgba(0,0,0,0.5); }
        .hero p { font-size: clamp(13px, 2vw, 18px); opacity: 0.9; max-width: 600px; margin: 0 auto 30px; }
        .hero .btn-mulai { background: #2e7d32; color: white; padding: clamp(10px, 2vw, 14px) clamp(25px, 4vw, 45px); border-radius: 30px; text-decoration: none; font-size: clamp(13px, 1.8vw, 16px); font-weight: bold; display: inline-block; transition: all 0.2s; }
        .hero .btn-mulai:hover { background: #1b5e20; transform: translateY(-2px); }

        /* FITUR */
        .fitur { padding: clamp(40px, 6vw, 80px) clamp(20px, 5vw, 60px); text-align: center; background: #111111; width: 100%; }
        .fitur h2 { font-size: clamp(20px, 3.5vw, 32px); color: #4caf50; margin-bottom: 10px; }
        .fitur .subtitle { color: #aaaaaa; margin-bottom: clamp(25px, 4vw, 50px); font-size: clamp(12px, 1.5vw, 15px); }
        .fitur-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 200px), 1fr)); gap: clamp(15px, 2vw, 30px); max-width: 1100px; margin: 0 auto; }
        .fitur-card { background: #1a1a1a; border-radius: 16px; padding: clamp(20px, 3vw, 35px) clamp(15px, 2vw, 25px); border-top: 4px solid #4caf50; box-shadow: 0 8px 30px rgba(0,0,0,0.3); transition: transform 0.2s, box-shadow 0.2s; }
        .fitur-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.4); }
        .fitur-card h3 { color: #4caf50; margin-bottom: 10px; font-size: clamp(14px, 1.8vw, 17px); }
        .fitur-card p { color: #aaaaaa; font-size: clamp(12px, 1.3vw, 14px); line-height: 1.6; }

        /* ROLE SECTION */
        .role-section { padding: clamp(40px, 6vw, 80px) clamp(20px, 5vw, 60px); background: #0d0d0d; text-align: center; width: 100%; }
        .role-section h2 { font-size: clamp(20px, 3.5vw, 32px); color: #4caf50; margin-bottom: 10px; }
        .role-section .subtitle { color: #aaaaaa; margin-bottom: clamp(25px, 4vw, 50px); font-size: clamp(12px, 1.5vw, 15px); }
        .role-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 200px), 1fr)); gap: clamp(15px, 2vw, 30px); max-width: 1100px; margin: 0 auto; }
        .role-card { background: #1a1a1a; border-radius: 16px; padding: clamp(20px, 3vw, 35px) clamp(15px, 2vw, 25px); box-shadow: 0 8px 30px rgba(0,0,0,0.3); transition: transform 0.2s, box-shadow 0.2s; border-bottom: 4px solid #2e7d32; }
        .role-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.4); }
        .role-card h3 { color: #4caf50; margin-bottom: 10px; font-size: clamp(14px, 1.8vw, 18px); }
        .role-card p { color: #aaaaaa; font-size: clamp(12px, 1.3vw, 13px); line-height: 1.7; }

        /* CTA */
        .cta { padding: clamp(40px, 6vw, 80px) clamp(20px, 5vw, 40px); background: #0a1a0a; text-align: center; color: white; width: 100%; }
        .cta h2 { font-size: clamp(18px, 3vw, 32px); margin-bottom: 15px; color: white; }
        .cta p { font-size: clamp(13px, 1.5vw, 16px); opacity: 0.8; margin-bottom: 25px; color: #aaaaaa; }
        .cta a { background: #2e7d32; color: white; padding: clamp(10px, 1.5vw, 13px) clamp(25px, 3vw, 40px); border-radius: 30px; text-decoration: none; font-weight: bold; font-size: clamp(13px, 1.5vw, 15px); transition: all 0.2s; display: inline-block; }
        .cta a:hover { background: #1b5e20; transform: translateY(-2px); }

        /* FOOTER */
        footer { background: #050505; color: rgba(255,255,255,0.5); text-align: center; padding: clamp(15px, 2vw, 25px); font-size: clamp(11px, 1.3vw, 14px); width: 100%; border-top: 1px solid rgba(76,175,80,0.2); }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            nav { padding: 12px 15px; }
            nav .logo { font-size: 18px; }
            nav .btn-group a { padding: 6px 12px; font-size: 12px; margin-left: 6px; }
            .fitur-grid { grid-template-columns: 1fr 1fr; }
            .role-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 480px) {
            nav .btn-group a { padding: 5px 10px; font-size: 11px; }
            .fitur-grid { grid-template-columns: 1fr; }
            .role-grid { grid-template-columns: 1fr; }
        }
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

    <div class="main-wrapper">

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

    </div>
</body>
</html>