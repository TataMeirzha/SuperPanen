<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SuperPanen</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body {
            background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('/images/hero.jpg');
            background-size: cover; background-position: center; background-attachment: fixed;
            display: flex; flex-direction: column; min-height: 100vh;
        }
        nav {
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(10px);
            padding: 15px 40px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid rgba(76,175,80,0.2);
        }
        nav .logo { color: white; font-size: 22px; font-weight: bold; text-decoration: none; }
        .container { flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px 20px; }
        .card {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            width: 100%; max-width: 420px;
            border: 1px solid rgba(76,175,80,0.3);
        }
        .card h2 { text-align: center; color: white; margin-bottom: 25px; font-size: 26px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; color: rgba(255,255,255,0.85); font-size: 14px; }
        .form-group input {
            width: 100%; padding: 11px 14px;
            border: 1px solid rgba(76,175,80,0.3);
            border-radius: 8px; font-size: 14px; outline: none;
            background: rgba(0,0,0,0.4); color: white;
            transition: border 0.2s;
        }
        .form-group input::placeholder { color: rgba(255,255,255,0.3); }
        .form-group input:focus { border-color: #4caf50; background: rgba(0,0,0,0.5); }
        .error { background: rgba(198,40,40,0.4); border: 1px solid rgba(198,40,40,0.5); color: #ef9a9a; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; }
        .success { background: rgba(46,125,50,0.4); border: 1px solid rgba(76,175,80,0.4); color: #a5d6a7; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; }
        .btn { width: 100%; padding: 12px; background: #1b5e20; color: white; border: none; border-radius: 8px; font-size: 15px; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: #2e7d32; }
        .link-text { text-align: center; margin-top: 15px; font-size: 13px; color: rgba(255,255,255,0.6); }
        .link-text a { color: #4caf50; font-weight: bold; text-decoration: none; }
        footer { background: rgba(0,0,0,0.8); color: rgba(255,255,255,0.4); text-align: center; padding: 15px; font-size: 13px; border-top: 1px solid rgba(76,175,80,0.15); }
    </style>
</head>
<body>
    <nav><a href="/" class="logo">SuperPanen</a></nav>
    <div class="container">
        <div class="card">
            <h2>Login</h2>
            @if($errors->any())
                <div class="error">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            @endif
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <form action="/login" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••">
                </div>
                <button type="submit" class="btn">Masuk</button>
            </form>
            <div class="link-text">Belum punya akun? <a href="/register">Daftar di sini</a></div>
        </div>
    </div>
    <footer><p>&copy; 2026 SuperPanen</p></footer>
</body>
</html>