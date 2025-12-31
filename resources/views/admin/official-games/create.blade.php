<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Game Official - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .container { max-width: 800px; margin: 50px auto; padding: 0 20px; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        h1 { margin-bottom: 30px; color: #333; text-align: center; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; }
        input[type="text"], textarea, select { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 16px; transition: border 0.3s; }
        input:focus, textarea:focus, select:focus { border-color: #667eea; outline: none; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .radio-group { display: flex; gap: 20px; }
        .radio-option { flex: 1; cursor: pointer; }
        .radio-option input { display: none; }
        .radio-card { border: 2px solid #e2e8f0; padding: 20px; border-radius: 10px; text-align: center; transition: all 0.3s; }
        .radio-card:hover { border-color: #cbd5e1; }
        .radio-option input:checked + .radio-card { border-color: #667eea; background: #eff6ff; color: #1e40af; }
        .icon { font-size: 30px; display: block; margin-bottom: 10px; }

        .btn-submit { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; width: 100%; margin-top: 20px; transition: transform 0.2s; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-back { display: block; text-align: center; margin-top: 20px; text-decoration: none; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>➕ Tambah Game Official Baru</h1>
            
            <form action="{{ route('admin.official-games.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Pilih Bahasa Kurikulum</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="language" value="arab" checked>
                            <div class="radio-card">
                                <span class="icon">🇸🇦</span>
                                <strong>Bahasa Arab</strong>
                            </div>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="language" value="inggris">
                            <div class="radio-card">
                                <span class="icon">🇬🇧</span>
                                <strong>Bahasa Inggris</strong>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Judul Game</label>
                    <input type="text" id="title" name="title" required placeholder="Contoh: Petualangan Huruf Hijaiyah">
                </div>

                <div class="form-group">
                    <label>Target Kelas Siswa</label>
                    <select name="class_level" style="border: 2px solid #e2e8f0; background: #fff;">
                        <option value="">-- Semua Kelas (1-6 SD) --</option>
                        <option value="1">Kelas 1 SD</option>
                        <option value="2">Kelas 2 SD</option>
                        <option value="3">Kelas 3 SD</option>
                        <option value="4">Kelas 4 SD</option>
                        <option value="5">Kelas 5 SD</option>
                        <option value="6">Kelas 6 SD</option>
                    </select>
                    <small style="color: #64748b; font-size: 0.85rem; margin-top: 5px; display: block;">Pilih kelas spesifik atau biarkan kosong untuk semua kelas.</small>
                </div>

                <div class="form-group">
                    <label for="category">Kategori Game</label>
                    <select name="category" id="category" required>
                        <option value="Match Pairs">🧩 Mencocokkan Pasangan</option>
                        <option value="Multiple Choice">📝 Pilihan Ganda</option>
                        <option value="Word Scramble">🔠 Susun Kata</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="3" required placeholder="Deskripsikan tujuan pembelajaran game ini..."></textarea>
                </div>

                <div class="form-group">
                    <label>Pilih Metode Pembuatan Game</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="game_type" value="template" checked onchange="toggleGameType()">
                            <div class="radio-card">
                                <span class="icon">📋</span>
                                <strong>Gunakan Template</strong>
                                <p style="font-size: 12px; margin-top: 5px; color: #666;">Pilih template siap pakai</p>
                            </div>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="game_type" value="custom" onchange="toggleGameType()">
                            <div class="radio-card">
                                <span class="icon">💻</span>
                                <strong>Custom Code</strong>
                                <p style="font-size: 12px; margin-top: 5px; color: #666;">Tulis kode sendiri</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="template-section" class="form-group">
                    <label>Pilih Template Game</label>
                    <select name="template_type" id="template_type">
                        <option value="">-- Pilih Template --</option>
                        <option value="multiple_choice">📝 Multiple Choice (Pilihan Ganda)</option>
                        <option value="fill_blank">✍️ Fill in the Blank (Isi Titik-titik)</option>
                        <option value="matching">🔗 Matching (Menjodohkan)</option>
                    </select>
                </div>

                <div id="custom-section" class="form-group" style="display: none;">
                    <label for="custom_html">Custom HTML/JavaScript</label>
                    <textarea name="custom_html" id="custom_html" rows="10" placeholder="Masukkan kode HTML dan JavaScript Anda di sini..."></textarea>
                    <small style="color: #64748b; margin-top: 5px; display: block;">Kode ini akan dijalankan sebagai game. Pastikan sudah ditest terlebih dahulu.</small>
                </div>

                <div class="form-group">
                    <label for="thumbnail">Cover Game (Opsional)</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                </div>

                <script>
                function toggleGameType() {
                    const gameType = document.querySelector('input[name="game_type"]:checked').value;
                    const templateSection = document.getElementById('template-section');
                    const customSection = document.getElementById('custom-section');
                    
                    if (gameType === 'template') {
                        templateSection.style.display = 'block';
                        customSection.style.display = 'none';
                        document.getElementById('template_type').required = true;
                        document.getElementById('custom_html').required = false;
                    } else {
                        templateSection.style.display = 'none';
                        customSection.style.display = 'block';
                        document.getElementById('template_type').required = false;
                        document.getElementById('custom_html').required = true;
                    }
                }
                </script>

                <button type="submit" class="btn-submit">Simpan & Buat Game</button>
                <a href="{{ route('admin.official-games') }}" class="btn-back">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
