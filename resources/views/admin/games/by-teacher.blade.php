<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game oleh {{ $teacher->name }} - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .header { background: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .games-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .game-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .game-card:hover { transform: translateY(-5px); }
        .game-thumbnail { width: 100%; height: 200px; object-fit: cover; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; }
        .game-thumbnail img { width: 100%; height: 100%; object-fit: cover; }
        .game-body { padding: 20px; }
        .game-title { font-size: 20px; font-weight: bold; color: #333; margin-bottom: 10px; }
        .game-meta { display: flex; gap: 10px; margin-bottom: 15px; font-size: 12px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .btn { padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 13px; display: inline-block; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🎮 Game oleh {{ $teacher->name }}</h1>
        <div>
            <a href="{{ route('admin.games') }}">← Kembali ke Daftar Guru</a>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>👨‍🏫 {{ $teacher->name }}</h2>
            <p style="color: #666; margin-top: 10px;">Total {{ $games->count() }} game yang dibuat</p>
        </div>

        @if($games->count() > 0)
            <div class="games-grid">
                @foreach($games as $game)
                    <div class="game-card">
                        <div class="game-thumbnail">
                            @if($game->thumbnail)
                                <img src="{{ asset($game->thumbnail) }}" alt="{{ $game->title }}">
                            @else
                                🎯
                            @endif
                        </div>
                        <div class="game-body">
                            <div class="game-title">{{ $game->title }}</div>
                            <div class="game-meta">
                                <span class="badge {{ $game->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $game->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if($game->category)
                                    <span class="badge" style="background: #e0e7ff; color: #3730a3;">{{ $game->category }}</span>
                                @endif
                            </div>
                            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">
                                {{ Str::limit($game->description, 100) }}
                            </p>
                            <div style="color: #999; font-size: 12px; margin-bottom: 15px;">
                                📝 {{ $game->questions->count() }} soal
                            </div>
                            <a href="{{ route('admin.questions', $game->id) }}" class="btn btn-primary">
                                👁️ Lihat Soal
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px; background: white; border-radius: 15px;">
                <div style="font-size: 64px; margin-bottom: 20px;">🎮</div>
                <h3 style="color: #666;">Belum ada game</h3>
            </div>
        @endif
    </div>
</body>
</html>
