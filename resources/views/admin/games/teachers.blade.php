<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Guru - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .teacher-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .teacher-card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; cursor: pointer; }
        .teacher-card:hover { transform: translateY(-5px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .teacher-name { font-size: 20px; font-weight: bold; color: #333; margin-bottom: 10px; }
        .teacher-info { color: #666; font-size: 14px; margin-bottom: 8px; }
        .game-count { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 15px; border-radius: 20px; display: inline-block; font-size: 14px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>👨‍🏫 Daftar Guru & Game</h1>
        <div>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.logout') }}">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>Pilih Guru untuk Melihat Game-nya</h2>
        </div>

        @if($teachers->count() > 0)
            <div class="teacher-grid">
                @foreach($teachers as $teacher)
                    <a href="{{ route('admin.games.by-teacher', $teacher->id) }}" style="text-decoration: none;">
                        <div class="teacher-card">
                            <div class="teacher-name">👨‍🏫 {{ $teacher->name }}</div>
                            @if($teacher->email)
                                <div class="teacher-info">📧 {{ $teacher->email }}</div>
                            @endif
                            @if($teacher->phone)
                                <div class="teacher-info">📱 {{ $teacher->phone }}</div>
                            @endif
                            <div style="margin-top: 15px;">
                                <span class="game-count">🎮 {{ $teacher->games_count }} Game</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px; background: white; border-radius: 15px;">
                <div style="font-size: 64px; margin-bottom: 20px;">👨‍🏫</div>
                <h3 style="color: #666;">Belum ada guru yang membuat game</h3>
            </div>
        @endif
    </div>
</body>
</html>
