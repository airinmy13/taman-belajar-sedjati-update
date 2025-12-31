<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - Game Edukasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .container { max-width: 500px; width: 100%; text-align: center; }
        .card { background: white; padding: 50px 30px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .icon-success { font-size: 80px; margin-bottom: 20px; display: block; }
        h1 { color: #333; margin-bottom: 15px; font-size: 28px; }
        p { color: #666; margin-bottom: 30px; line-height: 1.6; }
        .btn { display: inline-block; padding: 15px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 30px; font-size: 16px; font-weight: bold; text-decoration: none; transition: transform 0.3s; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="icon-success">✅</div>
            <h1>Pendaftaran Berhasil!</h1>
            <p>Terima kasih telah mendaftar. Data Anda telah kami terima dan sedang dalam proses verifikasi oleh admin.</p>
            <p>Mohon tunggu email konfirmasi dari kami untuk informasi selanjutnya terkait akun Anda.</p>
            
            <a href="{{ route('home') }}" class="btn">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
