<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akses Ditolak</title>
    <style>
        body { font-family: sans-serif; display: flex; align-items: center;
               justify-content: center; height: 100vh; margin: 0; background: #f9f9f9; }
        .box { text-align: center; }
        .box h1 { font-size: 48px; margin: 0; color: #C0392B; }
        .box p  { color: #666; margin: 8px 0 24px; }
        .links { display: flex; gap: 12px; justify-content: center; }
        .links a { padding: 10px 20px; background: #C0392B; color: white;
                   text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>
    <div class="box">
        <h1>403</h1>
        <p>Kamu tidak punya akses ke halaman ini.<br>Silakan login dengan akun yang sesuai.</p>
        <div class="links">
            <a href="/admin/login">Login Admin</a>
            <a href="/editor/login">Login Editor</a>
            <a href="/penulis/login">Login Penulis</a>
        </div>
    </div>
</body>
</html>
