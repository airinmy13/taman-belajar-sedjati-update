<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal - {{ $game->title }}</title>
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
        .game-info { background: #f0f4ff; padding: 15px; border-radius: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>➕ Tambah Soal Baru</h1>
        <div>
            @php
                $backRoute = session('teacher_id') ? route('teacher.questions', $game->id) : route('admin.questions', $game->id);
                $listRoute = session('teacher_id') ? route('teacher.games') : route('admin.games');
            @endphp
            <a href="{{ $backRoute }}">Kembali</a>
            <a href="{{ $listRoute }}">Daftar Game</a>
        </div>
    </div>

    <div class="container">
        <div class="game-info">
            <strong>Game:</strong> {{ $game->title }}
        </div>

        <div class="card">
            @php
                $storeRoute = session('teacher_id') ? route('teacher.questions.store', $game->id) : route('admin.questions.store', $game->id);
            @endphp
            <form action="{{ $storeRoute }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="game_id" value="{{ $game->id }}">
                
                @if($game->game_type == 'matching')
                    {{-- Matching Game: Multiple Pairs --}}
                    <div style="background: #f0f9ff; padding: 20px; border-radius: 10px; border: 2px solid #3b82f6; margin-bottom: 20px;">
                        <h3 style="color: #1e40af; margin-bottom: 15px;">🔗 Pasangan Kata untuk Matching Game</h3>
                        <p style="color: #64748b; margin-bottom: 20px;">Tambahkan minimal 3 pasangan kata. Saat game dimainkan, kartu akan diacak otomatis!</p>
                        
                        <div id="pairs-container">
                            {{-- Initial 3 pairs --}}
                            <div class="pair-item" style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e2e8f0;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <strong style="color: #475569;">Pasangan 1</strong>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                    <div>
                                        <label style="font-size: 14px; color: #64748b;">Kata/Kalimat 1</label>
                                        <input type="text" name="pairs[0][word1]" required placeholder="Contoh: Apple" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                                    </div>
                                    <div>
                                        <label style="font-size: 14px; color: #64748b;">Pasangannya</label>
                                        <input type="text" name="pairs[0][word2]" required placeholder="Contoh: Apel" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                                    </div>
                                </div>
                            </div>

                            <div class="pair-item" style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e2e8f0;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <strong style="color: #475569;">Pasangan 2</strong>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                    <div>
                                        <label style="font-size: 14px; color: #64748b;">Kata/Kalimat 1</label>
                                        <input type="text" name="pairs[1][word1]" required placeholder="Contoh: Book" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                                    </div>
                                    <div>
                                        <label style="font-size: 14px; color: #64748b;">Pasangannya</label>
                                        <input type="text" name="pairs[1][word2]" required placeholder="Contoh: Buku" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                                    </div>
                                </div>
                            </div>

                            <div class="pair-item" style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e2e8f0;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <strong style="color: #475569;">Pasangan 3</strong>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                    <div>
                                        <label style="font-size: 14px; color: #64748b;">Kata/Kalimat 1</label>
                                        <input type="text" name="pairs[2][word1]" required placeholder="Contoh: Cat" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                                    </div>
                                    <div>
                                        <label style="font-size: 14px; color: #64748b;">Pasangannya</label>
                                        <input type="text" name="pairs[2][word2]" required placeholder="Contoh: Kucing" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="addPair()" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                            + Tambah Pasangan
                        </button>
                        <small style="display: block; margin-top: 10px; color: #64748b;">Maksimal 10 pasangan</small>
                    </div>
                @else
                    {{-- Other Game Types: Standard Question/Answer --}}
                    <div class="form-group">
                        <label for="question_text">Pertanyaan *</label>
                        <textarea id="question_text" name="question_text" required placeholder="Tulis pertanyaan di sini..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Gambar (Opsional)</label>
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        <small style="color: #666; display: block; margin-top: 5px;">Format: JPG, PNG, GIF. Max: 2MB</small>
                        <img id="imagePreview" style="max-width: 300px; margin-top: 10px; display: none; border-radius: 10px;">
                    </div>

                    <div class="form-group">
                        <label for="correct_answer">
                            {{ $game->game_type == 'multiple_choice' ? 'Jawaban Benar (Ketik A, B, C, atau D) *' : 'Jawaban yang Benar *' }}
                        </label>
                        <input type="text" id="correct_answer" name="correct_answer" required placeholder="{{ $game->game_type == 'multiple_choice' ? 'Contoh: A' : 'Jawaban yang benar' }}">
                    </div>

                    @if($game->game_type == 'multiple_choice')
                    <div id="multiple_choice_options" style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                        <h4 style="margin-bottom: 15px; color: #475569;">Pilihan Jawaban</h4>
                        <div class="form-group">
                            <label>Pilihan A</label>
                            <input type="text" name="options[]" required placeholder="Jawaban A">
                        </div>
                        <div class="form-group">
                            <label>Pilihan B</label>
                            <input type="text" name="options[]" required placeholder="Jawaban B">
                        </div>
                        <div class="form-group">
                            <label>Pilihan C</label>
                            <input type="text" name="options[]" required placeholder="Jawaban C">
                        </div>
                        <div class="form-group">
                            <label>Pilihan D</label>
                            <input type="text" name="options[]" required placeholder="Jawaban D">
                        </div>
                    </div>
                    @endif
                @endif

                <div class="form-group">
                    <label for="points">Poin</label>
                    <input type="number" id="points" name="points" value="10" min="1" placeholder="10">
                </div>

                <div class="form-group">
                    <label for="difficulty">Tingkat Kesulitan</label>
                    <select id="difficulty" name="difficulty">
                        <option value="easy">Mudah</option>
                        <option value="medium" selected>Sedang</option>
                        <option value="hard">Sulit</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label for="is_active" style="margin: 0;">Aktifkan soal ini</label>
                    </div>
                </div>



                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Simpan Soal</button>
                    <a href="{{ route('admin.questions', $game->id) }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
    <script src="{{ asset('js/matching-pairs.js') }}"></script>
</body>
</html>
