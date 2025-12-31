<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 20px; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Akun Guru Disetujui!</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $teacher->name }}</strong>,</p>
            
            <p>Selamat! Akun guru Anda di <strong>Platform Game Edukasi</strong> telah disetujui oleh Super Admin.</p>
            
            <p><strong>Detail Akun:</strong></p>
            <ul>
                <li>Username: <strong>{{ $teacher->username }}</strong></li>
                <li>Email: {{ $teacher->email }}</li>
                <li>Mata Pelajaran: {{ implode(', ', $teacher->subjects ?? []) }}</li>
            </ul>
            
            <p>Anda sekarang dapat login dan mulai membuat game edukasi untuk siswa!</p>
            
            <a href="{{ url('/teacher/login') }}" class="button">Login Sekarang</a>
            
            <p style="margin-top: 30px;">Terima kasih telah bergabung dengan kami!</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Platform Game Edukasi. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
