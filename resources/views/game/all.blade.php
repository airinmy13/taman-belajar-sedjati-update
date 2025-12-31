<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Game - Platform Game Edukasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #87CEEB 0%, #E0F7FA 60%, #FFFFFF 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-back {
            background: #10b981;
            color: white;
        }

        .btn-back:hover {
            background: #059669;
        }

        .btn-logout {
            background: #ef4444;
            color: white;
        }

        .btn-logout:hover {
            background: #dc2626;
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .page-header h1 {
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .game-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .game-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .game-thumbnail {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
            color: white;
        }

        .game-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .game-body {
            padding: 20px;
        }

        .game-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .game-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .game-meta {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 12px;
            color: #999;
        }

        .btn-play {
            width: 100%;
            background: #FFD700;
            color: #1e293b;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }

        .btn-play:hover {
            background: #FFEC8B;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">🌊 Platform Game Edukasi</div>
        <div class="navbar-user">
            <a href="{{ route('home') }}" class="btn btn-back">← Kembali</a>
            @if(session('student_name'))
                <span style="color: #666;">👋 {{ session('student_name') }}</span>
                <a href="{{ route('student.logout') }}" class="btn btn-logout">Keluar</a>
            @else
                <button onclick="showLoginModal()" class="btn btn-logout" style="background: #10b981;">Login</button>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h1>🎮 Semua Game Tersedia</h1>
            <p style="color: #666; font-size: 16px;">Total {{ $games->count() }} game siap dimainkan!</p>
        </div>

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
                        <div class="game-description">
                            {{ Str::limit($game->description, 80) }}
                        </div>
                        <div class="game-meta">
                            @if($game->category)
                                <span>📚 {{ $game->category }}</span>
                            @endif
                            <span>📝 {{ $game->activeQuestions()->count() }} soal</span>
                        </div>
                        <form action="{{ route('games.start', $game->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-play" style="border: none; cursor: pointer;">
                                🎮 Ayo Mainkan Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Student Login Modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 30px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #ffcc00, #ffd608); border: none; padding: 2rem; border-radius: 30px 30px 0 0;">
                    <h5 class="modal-title" style="color: #1e293b; font-size: 2rem; font-weight: 700; width: 100%; text-align: center;">
                        🎮 Login untuk Bermain!
                    </h5>
                </div>
                <div class="modal-body" style="padding: 2.5rem;">
                    <form action="{{ route('student.login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">📝 Siapa namamu?</label>
                            <input type="text" class="form-control" name="nama_anak" required placeholder="Masukkan nama kamu...">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">🎓 Kamu kelas berapa?</label>
                            <select class="form-select" name="kelas" required>
                                <option value="">Pilih kelas...</option>
                                <option value="1">Kelas 1</option>
                                <option value="2">Kelas 2</option>
                                <option value="3">Kelas 3</option>
                                <option value="4">Kelas 4</option>
                                <option value="5">Kelas 5</option>
                                <option value="6">Kelas 6</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn-primary" style="width: 100%; font-size: 1.3rem; padding: 1rem; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; border: none; border-radius: 50px; font-weight: 700;">
                                🚀 Mulai Petualangan!
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 50px; padding: 0.8rem; font-weight: 600;">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoginModal() {
            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
        }
    </script>
</body>
</html>
