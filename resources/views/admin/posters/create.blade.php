<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Poster - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .container { max-width: 600px; margin: 50px auto; padding: 0 20px; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        h1 { margin-bottom: 30px; color: #333; text-align: center; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; }
        input[type="text"], textarea, select { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 16px; transition: border 0.3s; }
        input:focus { border-color: #667eea; outline: none; }
        
        .file-upload { border: 2px dashed #cbd5e1; padding: 30px; text-align: center; border-radius: 10px; cursor: pointer; transition: all 0.3s; }
        .file-upload:hover { border-color: #667eea; background: #f8fafc; }

        .btn-submit { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; width: 100%; margin-top: 20px; }
        .btn-back { display: block; text-align: center; margin-top: 20px; text-decoration: none; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📸 Upload Poster Baru</h1>
            
            
            @if($errors->any())
                <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <strong>Error:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.posters.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Pilih Bahasa</label>
                    <select name="category" required>
                        <option value="arab">🇸🇦 Bahasa Arab</option>
                        <option value="inggris">🇬🇧 Bahasa Inggris</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Judul Poster</label>
                    <input type="text" name="title" required placeholder="Contoh: Kosa Kata Hewan">
                </div>

                <div class="form-group">
                    <label>Deskripsi (Opsional)</label>
                    <textarea name="description" rows="2" placeholder="Keterangan tambahan..."></textarea>
                </div>

                <div class="form-group">
                    <label>File Gambar Poster</label>
                    <input type="file" name="image" accept="image/*" required class="file-upload">
                </div>

                <button type="submit" class="btn-submit">Upload Poster</button>
                <a href="{{ route('admin.posters') }}" class="btn-back">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
