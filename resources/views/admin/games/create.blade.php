<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Game - Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; }
        .container { max-width: 800px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; font-family: inherit; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #667eea; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .form-actions { display: flex; gap: 10px; margin-top: 30px; }
        .btn { padding: 12px 30px; border-radius: 8px; text-decoration: none; font-size: 14px; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-secondary { background: #6b7280; color: white; }
        .btn:hover { transform: translateY(-2px); }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>➕ Tambah Game Baru</h1>
        <div>
            @php
                $isTeacher = request()->is('teacher/*');
                $gamesRoute = $isTeacher ? route('teacher.games') : route('admin.games');
                $dashboardRoute = $isTeacher ? route('teacher.dashboard') : route('admin.dashboard');
            @endphp
            <a href="{{ $gamesRoute }}">Daftar Game</a>
            <a href="{{ $dashboardRoute }}">Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            @php
                $storeRoute = request()->is('teacher/*') ? route('teacher.games.store') : route('admin.games.store');
            @endphp
            <form action="{{ $storeRoute }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="title">Nama Game *</label>
                    <input type="text" id="title" name="title" required placeholder="Contoh: Teka-Teki Silang">
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" placeholder="Jelaskan tentang game ini..."></textarea>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" id="category" name="category" placeholder="Contoh: Bahasa, Matematika, dll">
                </div>

                <div class="form-group">
                    <label for="class_level">Target Kelas Siswa *</label>
                    <select id="class_level" name="class_level" required>
                        <option value="">-- Pilih Kelas --</option>
                        <option value="0">Semua Kelas (1-6)</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                        <option value="3">Kelas 3</option>
                        <option value="4">Kelas 4</option>
                        <option value="5">Kelas 5</option>
                        <option value="6">Kelas 6</option>
                    </select>
                    <small style="color: #666; display: block; margin-top: 5px;">Pilih kelas yang akan mengakses game ini</small>
                </div>

                <div class="form-group">
                    <label for="thumbnail">Gambar Thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                    <small style="color: #666; display: block; margin-top: 5px;">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                </div>

                <hr style="margin: 30px 0; border: none; border-top: 2px solid #e0e0e0;">
                
                <h3 style="color: #667eea; margin-bottom: 20px;">🎮 Opsi Pembuatan Game</h3>
                
                <div class="form-group">
                    <label for="game_type">Metode Pembuatan *</label>
                    <select id="game_type" name="game_type" required onchange="toggleGameType()">
                        <option value="matching">Gunakan Template: Matching Game</option>
                        <option value="multiple_choice">Gunakan Template: Pilihan Ganda</option>
                        <option value="fill_blank">Gunakan Template: Isian Singkat</option>
                        <option value="custom_code">Custom Code (HTML/JS)</option>
                    </select>
                </div>

                <div id="template_info" class="form-group" style="background: #f0f7ff; padding: 15px; border-radius: 10px; border-left: 4px solid #667eea;">
                    <p id="template_description" style="font-size: 14px; color: #444;">
                        <strong>💡 Template Matching Game:</strong> Anda cukup menambah soal (kata & terjemahan/pasangan) setelah menyimpan game ini. Sistem akan otomatis membuatkan gamenya untuk Anda!
                    </p>
                </div>

                <div id="custom_code_area" style="display: none;">
                <p style="color: #666; margin-bottom: 20px; font-size: 14px;">
                    Masukkan kode HTML lengkap dengan CSS dan JavaScript untuk custom game template. Kode ini akan dirender sebagai halaman game.
                </p>

                <div class="form-group">
                    <label for="custom_template">Complete HTML/CSS/JS Code</label>
                    <textarea id="custom_template" name="custom_template" style="font-family: 'Courier New', monospace; min-height: 400px; font-size: 13px;" placeholder="<!DOCTYPE html>
<html>
<head>
    <style>
        /* CSS di sini */
    </style>
</head>
<body>
    <div class='game-container'>
        <h2>Judul Game</h2>
    </div>
    <script>
        // JS di sini
    </script>
</body>
</html>"></textarea>
                    <small style="color: #666; display: block; margin-top: 5px;">
                        💡 Masukkan kode HTML lengkap termasuk &lt;style&gt; dan &lt;script&gt; tags
                    </small>
                </div>
            </div>

            <script>
                function toggleGameType() {
                    const type = document.getElementById('game_type').value;
                    const templateInfo = document.getElementById('template_info');
                    const templateDesc = document.getElementById('template_description');
                    const customArea = document.getElementById('custom_code_area');
                    
                    if (type === 'custom_code') {
                        templateInfo.style.display = 'none';
                        customArea.style.display = 'block';
                    } else {
                        templateInfo.style.display = 'block';
                        customArea.style.display = 'none';
                        
                        if (type === 'matching') {
                            templateDesc.innerHTML = '<strong>💡 Template Matching Game:</strong> Anda cukup menambah soal (kata & terjemahan/pasangan) setelah menyimpan game ini. Sistem akan otomatis membuatkan gamenya untuk Anda!';
                        } else if (type === 'multiple_choice') {
                            templateDesc.innerHTML = '<strong>💡 Template Pilihan Ganda:</strong> Siswa akan memilih satu dari 4 pilihan jawaban yang Anda buat. Cocok untuk kuis cepat!';
                        } else if (type === 'fill_blank') {
                            templateDesc.innerHTML = '<strong>💡 Template Isian Singkat:</strong> Siswa akan mengetik jawaban secara manual. Pastikan jawaban yang Anda masukkan singkat dan padat.';
                        }
                    }
                }
            </script>

                <hr style="margin: 30px 0; border: none; border-top: 2px solid #e0e0e0;">

                <div class="form-group">
                    <label for="order">Urutan Tampilan</label>
                    <input type="number" id="order" name="order" value="0" min="0" placeholder="0">
                    <small style="color: #666; display: block; margin-top: 5px;">Semakin kecil angka, semakin di depan</small>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label for="is_active" style="margin: 0;">Aktifkan game ini</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Simpan Game</button>
                    <a href="{{ route('admin.games') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
