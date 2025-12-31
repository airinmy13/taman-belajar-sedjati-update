<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mentor - Super Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h1 { font-size: 24px; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .header { margin-bottom: 30px; }
        .header h2 { color: #333; margin-bottom: 10px; }
        .header p { color: #666; }
        .teachers-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .teacher-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s; cursor: pointer; text-decoration: none; display: block; color: inherit; }
        .teacher-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2); }
        .teacher-avatar { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 15px; }
        .teacher-name { font-size: 20px; font-weight: bold; color: #333; text-align: center; margin-bottom: 8px; }
        .teacher-email { font-size: 13px; color: #999; text-align: center; margin-bottom: 15px; }
        .teacher-stats { display: flex; justify-content: space-around; padding-top: 15px; border-top: 1px solid #e5e7eb; }
        .stat { text-align: center; }
        .stat-number { font-size: 24px; font-weight: bold; color: #667eea; }
        .stat-label { font-size: 12px; color: #999; margin-top: 4px; }
        .empty-state { text-align: center; padding: 80px 20px; background: white; border-radius: 15px; }
        .empty-state-icon { font-size: 64px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>👨‍🏫 Daftar Mentor & Game Mereka</h1>
        <div>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.logout') }}">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>Mentor yang Telah Membuat Game</h2>
            <p>Klik pada mentor untuk melihat semua game yang mereka buat</p>
        </div>

        @if(count($teachers) > 0)
            <div class="teachers-grid">
                @foreach($teachers as $teacher)
                    <a href="{{ route('admin.games.by-teacher', $teacher->id) }}" class="teacher-card">
                        <div class="teacher-avatar">
                            👨‍🏫
                        </div>
                        <div class="teacher-name">{{ $teacher->name }}</div>
                        <div class="teacher-email">{{ $teacher->email }}</div>
                        <div class="teacher-stats">
                            <div class="stat">
                                <div class="stat-number">{{ $teacher->games_count }}</div>
                                <div class="stat-label">Game</div>
                            </div>
                            <div class="stat">
                                <div class="stat-number">{{ $teacher->active_games_count }}</div>
                                <div class="stat-label">Aktif</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🎮</div>
                <h3 style="color: #666; margin-bottom: 10px;">Belum Ada Mentor yang Membuat Game</h3>
                <p style="color: #999;">Mentor akan muncul di sini setelah mereka membuat game pertama mereka.</p>
            </div>
        @endif
    </div>
</body>
</html>
