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
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* FRAME / CARD WRAPPER */
        .frame {
            width: 100%;
            max-width: 480px;
            background: #111;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(76,175,80,0.3);
            border: 1px solid rgba(76,175,80,0.2);
        }

        /* Browser bar mockup */
        .browser-bar {
            background: #1a1a1a;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .browser-bar .dot { width: 10px; height: 10px; border-radius: 50%; }
        .dot-red { background: #ff5f57; }
        .dot-yellow { background: #febc2e; }
        .dot-green { background: #28c840; }
        .browser-bar .url-bar {
            flex: 1;
            background: #2a2a2a;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            margin-left: 8px;
        }

        /* SCROLLABLE CONTENT DALAM FRAME */
        .frame-content {
            height: 75vh;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #2e7d32 #1a1a1a;
        }
        .frame-content::-webkit-scrollbar { width: 4px; }
        .frame-content::-webkit-scrollbar-track { background: #1a1a1a; }
        .frame-content::-webkit-scrollbar-thumb { background: #2e7d32; border-radius: 4px; }

        /* NAVBAR */
        nav {
            background: #0a0a0a;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(76,175,80,0.15);
        }
        nav .logo { color: white; font-size: 16px; font-weight: bold; text-decoration: none; }
        nav .btn-group { display: flex; gap: 8px; }
        nav .btn-group a { text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 11px; transition: all 0.2s; }
        nav .btn-login { background: #1b5e20; color: white; }
        nav .btn-login:hover { background: #2e7d32; }
        nav .btn-daftar { background: transparent; color: #4caf50; border: 1.5px solid #4caf50; }
        nav .btn-daftar:hover { background: rgba(76,175,80,0.1); }

        /* HERO */
        .hero {
            background-image: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('/images/hero.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: 60px 20px;
            color: white;
        }
        .hero h1 { font-size: 26px; margin-bottom: 12px; text-shadow: 0 2px 8px rgba(0,0,0,0.5); }
        .hero p { font-size: 13px; opacity: 0.85; max-width: 100%; margin: 0 auto 20px; line-height: 1.6; }
        .hero .btn-mulai { background: #2e7d32; color: white; padding: 10px 28px; border-radius: 20px; text-decoration: none; font-size: 13px; font-weight: bold; display: inline-block; transition: all 0.2s; }
        .hero .btn-mulai:hover { background: #1b5e20; }

        /* FITUR */
        .fitur { padding: 30px 20px; text-align: center; background: #111111; }
        .fitur h2 { font-size: 18px; color: #4caf50; margin-bottom: 6px; }
        .fitur .subtitle { color: #888; margin-bottom: 20px; font-size: 12px; }
        .fitur-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .fitur-card { background: #1a1a1a; border-radius: 12px; padding: 16px 14px; border-top: 3px solid #4caf50; text-align: left; transition: transform 0.2s; }
        .fitur-card:hover { transform: translateY(-4px); }
        .fitur-card h3 { color: #4caf50; margin-bottom: 6px; font-size: 13px; }
        .fitur-card p { color: #888; font-size: 11px; line-height: 1.5; }

        /* ROLE SECTION */
        .role-section { padding: 30px 20px; background: #0d0d0d; text-align: center; }
        .role-section h2 { font-size: 18px; color: #4caf50; margin-bottom: 6px; }
        .role-section .subtitle { color: #888; margin-bottom: 20px; font-size: 12px; }
        .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .role-card { background: #1a1a1a; border-radius: 12px; padding: 16px 14px; border-bottom: 3px solid #2e7d32; text-align: left; transition: transform 0.2s; }
        .role-card:hover { transform: translateY(-4px); }
        .role-card h3 { color: #4caf50; margin-bottom: 6px; font-size: 13px; }
        .role-card p { color: #888; font-size: 11px; line-height: 1.5; }

        /* CTA */
        .cta { padding: 35px 20px; background: #0a1a0a; text-align: center; }
        .cta h2 { font-size: 18px; color: white; margin-bottom: 10px; }
        .cta p { font-size: 12px; color: #888; margin-bottom: 20px; }
        .cta a { background: #2e7d32; color: white; padding: 10px 28px; border-radius: 20px; text-decoration: none; font-weight: bold; font-size: 13px; display: inline-block; transition: all 0.2s; }
        .cta a:hover { background: #1b5e20; }

        /* FOOTER */
        footer { background: #050505; color: rgba(255,255,255,0.4); text-align: center; padding: 15px; font-size: 11px; border-top: 1px solid rgba(76,175,80,0.15); }

        /* OUTER - teks di luar frame */
        .outer-label {
            text-align: center;
            margin-top: 15px;
            color: rgba(255,255,255,0.3);
            font-size: 11px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <div style="width:100%; max-width:480px;">
        <div class="frame">

            <!-- Browser bar mockup -->
            <div class="browser-bar">
                <div class="dot dot-red"></div>
                <div class="dot dot-yellow"></div>
                <div class="dot dot-green"></div>
                <div class="url-bar">superpanen.id</div>
            </div>

            <!-- Konten website dalam frame -->
            <div class="frame-content">

                <nav>
                    <a href="/" class="logo">SuperPanen</a>
                    <div class="btn-group">
                        <a href="/register" class="btn-daftar">Daftar</a>
                        <a href="/login" class="btn-login">Login</a>
                    </div>
                </nav>

                <div class="hero">
                    <h1>SuperPanen</h1>
                    <p>Platform pertanian digital — catat panen, sewa alat, dan kelola usaha tani kamu dengan mudah.</p>
                    <a href="/register" class="btn-mulai">Mulai Sekarang</a>
                </div>

                <div class="fitur">
                    <h2>Fitur Unggulan</h2>
                    <p class="subtitle">Semua yang kamu butuhkan dalam satu platform</p>
                    <div class="fitur-grid">
                        <div class="fitur-card">
                            <h3>Catat Pra Panen</h3>
                            <p>Input data tanaman dan dapatkan estimasi lahan serta modal otomatis.</p>
                        </div>
                        <div class="fitur-card">
                            <h3>Sewa Alat Tani</h3>
                            <p>Temukan alat terdekat berdasarkan kecamatanmu.</p>
                        </div>
                        <div class="fitur-card">
                            <h3>Catat Pasca Panen</h3>
                            <p>Input hasil panen dan hitung keuntungan bersih otomatis.</p>
                        </div>
                        <div class="fitur-card">
                            <h3>Laporan dan Pengaduan</h3>
                            <p>Kirim laporan dan dapat respon langsung dari admin.</p>
                        </div>
                    </div>
                </div>

                <div class="role-section">
                    <h2>Untuk Siapa SuperPanen?</h2>
                    <p class="subtitle">Dirancang untuk semua pihak dalam ekosistem pertanian</p>
                    <div class="role-grid">
                        <div class="role-card">
                            <h3>Petani</h3>
                            <p>Catat panen, sewa alat, dan pantau keuntungan usaha tanimu.</p>
                        </div>
                        <div class="role-card">
                            <h3>Mitra Alat</h3>
                            <p>Daftarkan alat, atur harga sewa, dan kelola permintaan petani.</p>
                        </div>
                        <div class="role-card">
                            <h3>Admin Panen</h3>
                            <p>Pantau dan kelola data panen seluruh petani terdaftar.</p>
                        </div>
                        <div class="role-card">
                            <h3>Super Admin</h3>
                            <p>Kelola sistem, user, mitra, dan tangani laporan pengaduan.</p>
                        </div>
                    </div>
                </div>

                <div class="cta">
                    <h2>Siap Bergabung?</h2>
                    <p>Daftar sekarang dan mulai kelola pertanianmu lebih cerdas.</p>
                    <a href="/register">Daftar Gratis</a>
                </div>

                <footer>
                    <p>&copy; 2026 SuperPanen. Semua hak dilindungi.</p>
                </footer>

            </div>
        </div>
        <div class="outer-label">SUPERPANEN &mdash; PLATFORM PERTANIAN DIGITAL</div>
    </div>

</body>
</html>