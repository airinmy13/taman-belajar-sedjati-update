<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game - Admin</title>
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
        .current-thumbnail { max-width: 200px; border-radius: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>✏️ Edit Game</h1>
        <div>
            @php
                $gamesRoute = session('teacher_id') ? route('teacher.games') : route('admin.games');
                $dashboardRoute = session('teacher_id') ? route('teacher.dashboard') : route('admin.dashboard');
            @endphp
            <a href="{{ $gamesRoute }}">Daftar Game</a>
            <a href="{{ $dashboardRoute }}">Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <form action="{{ route('admin.games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Nama Game *</label>
                    <input type="text" id="title" name="title" value="{{ $game->title }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description">{{ $game->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" id="category" name="category" value="{{ $game->category }}">
                </div>

                <div class="form-group">
                    <label for="thumbnail">Gambar Thumbnail</label>
                    @if($game->thumbnail)
                        <img src="{{ asset($game->thumbnail) }}" alt="{{ $game->title }}" class="current-thumbnail">
                        <p style="color: #666; font-size: 12px; margin-top: 5px;">Upload gambar baru untuk mengganti</p>
                    @endif
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                </div>

                <hr style="margin: 30px 0; border: none; border-top: 2px solid #e0e0e0;">
                
                <h3 style="color: #667eea; margin-bottom: 20px;">🎮 Opsi Pembuatan Game</h3>
                
                <div class="form-group">
                    <label for="game_type">Metode Pembuatan *</label>
                    <select id="game_type" name="game_type" required onchange="toggleGameType()">
                        <option value="matching" {{ $game->game_type == 'matching' ? 'selected' : '' }}>Gunakan Template: Matching Game</option>
                        <option value="multiple_choice" {{ $game->game_type == 'multiple_choice' ? 'selected' : '' }}>Gunakan Template: Pilihan Ganda</option>
                        <option value="fill_blank" {{ $game->game_type == 'fill_blank' ? 'selected' : '' }}>Gunakan Template: Isian Singkat</option>
                        <option value="custom_code" {{ $game->game_type == 'custom_code' ? 'selected' : '' }}>Custom Code (HTML/JS)</option>
                    </select>
                </div>

                <div id="template_info" class="form-group" style="background: #f0f7ff; padding: 15px; border-radius: 10px; border-left: 4px solid #667eea; display: {{ $game->game_type == 'custom_code' ? 'none' : 'block' }};">
                    <p id="template_description" style="font-size: 14px; color: #444;">
                        @if($game->game_type == 'matching')
                            <strong>💡 Template Matching Game:</strong> Anda cukup menambah soal (kata & terjemahan/pasangan) di bagian bawah. Sistem akan otomatis membuatkan gamenya untuk Anda!
                        @elseif($game->game_type == 'multiple_choice')
                            <strong>💡 Template Pilihan Ganda:</strong> Siswa akan memilih satu dari 4 pilihan jawaban yang Anda buat. Cocok untuk kuis cepat!
                        @elseif($game->game_type == 'fill_blank')
                            <strong>💡 Template Isian Singkat:</strong> Siswa akan mengetik jawaban secara manual. Pastikan jawaban yang Anda masukkan singkat dan padat.
                        @else
                            <strong>💡 Template Matching Game:</strong> Anda cukup menambah soal (kata & terjemahan/pasangan) di bagian bawah. Sistem akan otomatis membuatkan gamenya untuk Anda!
                        @endif
                    </p>
                </div>

                <div id="custom_code_area" style="display: {{ $game->game_type == 'custom_code' ? 'block' : 'none' }};">
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
</html>">{{ $game->custom_template }}</textarea>
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
                            templateDesc.innerHTML = '<strong>💡 Template Matching Game:</strong> Anda cukup menambah soal (kata & terjemahan/pasangan) di bagian bawah. Sistem akan otomatis membuatkan gamenya untuk Anda!';
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
                    <input type="number" id="order" name="order" value="{{ $game->order }}" min="0">
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $game->is_active ? 'checked' : '' }}>
                        <label for="is_active" style="margin: 0;">Aktifkan game ini</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Update Game</button>
                    <a href="{{ route('admin.games') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
