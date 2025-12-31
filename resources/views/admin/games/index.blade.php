<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Game - Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h1 { font-size: 24px; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; transition: all 0.3s; border: none; cursor: pointer; display: inline-block; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-success { background: #10b981; color: white; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .alert { padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
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
        .game-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🎮 Kelola Game</h1>
        <div>
            @php
                $dashboardRoute = session('teacher_id') ? route('teacher.dashboard') : route('admin.dashboard');
                $logoutRoute = session('teacher_id') ? route('teacher.logout') : route('admin.logout');
            @endphp
            <a href="{{ $dashboardRoute }}">Dashboard</a>
            <a href="{{ $logoutRoute }}">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>Daftar Game</h2>
            @if($isTeacher)
                {{-- Only teachers can create games --}}
                <a href="{{ route('teacher.games.create') }}" class="btn btn-primary">+ Tambah Game Baru</a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                            <div style="color: #999; font-size: 12px; margin-bottom: 10px;">
                                📝 {{ $game->questions->count() }} soal
                            </div>
                            @if($game->teacher)
                                <div style="color: #667eea; font-size: 12px; margin-bottom: 15px; font-weight: 500;">
                                    👨‍🏫 Dibuat oleh: {{ $game->teacher->name }}
                                </div>
                            @endif
                            @if($isTeacher)
                                {{-- Teachers can manage their own games --}}
                                <div class="game-actions">
                                    <a href="{{ route('teacher.questions', $game->id) }}" class="btn btn-success btn-sm">Kelola Soal</a>
                                    <a href="{{ route('teacher.games.edit', $game->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('teacher.games.delete', $game->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus game ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            @else
                                {{-- Admin can only view --}}
                                <div style="color: #999; font-size: 13px; font-style: italic;">
                                    👁️ Mode Lihat Saja (Read-Only)
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px; background: white; border-radius: 15px;">
                <div style="font-size: 64px; margin-bottom: 20px;">🎮</div>
                <h3 style="color: #666; margin-bottom: 10px;">Belum ada game</h3>
                @if($isTeacher)
                    <p style="color: #999; margin-bottom: 20px;">Mulai dengan menambahkan game pertama Anda!</p>
                    <a href="{{ route('teacher.games.create') }}" class="btn btn-primary">+ Tambah Game Baru</a>
                @else
                    <p style="color: #999;">Belum ada game yang dibuat oleh guru.</p>
                @endif
            </div>
        @endif
    </div>
</body>
</html>
