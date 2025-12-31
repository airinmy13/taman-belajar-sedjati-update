<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game Official - Admin Panel</title>
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

        .btn-submit { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; width: 100%; margin-top: 20px; transition: transform 0.2s; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4); }
        .btn-back { display: block; text-align: center; margin-top: 20px; text-decoration: none; color: #64748b; }
        
        .current-thumb { margin-top: 10px; border-radius: 10px; width: 200px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>✏️ Edit Game Official</h1>
            
            <form action="{{ route('admin.official-games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Pilih Bahasa Kurikulum</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="language" value="arab" {{ $game->language == 'arab' ? 'checked' : '' }}>
                            <div class="radio-card">
                                <span class="icon">🇸🇦</span>
                                <strong>Bahasa Arab</strong>
                            </div>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="language" value="inggris" {{ $game->language == 'inggris' ? 'checked' : '' }}>
                            <div class="radio-card">
                                <span class="icon">🇬🇧</span>
                                <strong>Bahasa Inggris</strong>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Judul Game</label>
                    <input type="text" id="title" name="title" value="{{ $game->title }}" required>
                </div>

                <div class="form-group">
                    <label for="category">Kategori Game</label>
                    <select name="category" id="category" required>
                        <option value="Match Pairs" {{ $game->category == 'Match Pairs' ? 'selected' : '' }}>🧩 Mencocokkan Pasangan</option>
                        <option value="Multiple Choice" {{ $game->category == 'Multiple Choice' ? 'selected' : '' }}>📝 Pilihan Ganda</option>
                        <option value="Word Scramble" {{ $game->category == 'Word Scramble' ? 'selected' : '' }}>🔠 Susun Kata</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="3" required>{{ $game->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="thumbnail">Update Cover Game (Opsional)</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                    @if($game->thumbnail)
                        <img src="{{ asset($game->thumbnail) }}" alt="Current Cover" class="current-thumb">
                    @endif
                </div>

                <button type="submit" class="btn-submit">Update Perubahan</button>
                <a href="{{ route('admin.official-games') }}" class="btn-back">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
