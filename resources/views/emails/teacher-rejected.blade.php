<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .footer { text-align: center; margin-top: 20px; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❌ Pemberitahuan Pendaftaran</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $teacher->name }}</strong>,</p>
            
            <p>Terima kasih atas minat Anda untuk bergabung sebagai guru di <strong>Platform Game Edukasi</strong>.</p>
            
            <p>Mohon maaf, saat ini kami belum dapat menerima pendaftaran Anda. Hal ini mungkin disebabkan oleh:</p>
            <ul>
                <li>Kuota guru untuk mata pelajaran tertentu sudah terpenuhi</li>
                <li>Data yang diberikan belum lengkap atau tidak sesuai</li>
                <li>Alasan administratif lainnya</li>
            </ul>
            
            <p>Anda dapat mencoba mendaftar kembali di lain waktu atau menghubungi kami untuk informasi lebih lanjut.</p>
            
            <p style="margin-top: 30px;">Terima kasih atas pengertiannya.</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Platform Game Edukasi. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
