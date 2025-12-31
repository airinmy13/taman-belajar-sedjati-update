<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            font-size: 24px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 6px;
            transition: background 0.3s;
        }
        .navbar a:hover {
            background: rgba(255,255,255,0.3);
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .welcome {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .welcome h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .welcome p {
            color: #666;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid #667eea;
        }
        .stat-card h3 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 8px;
        }
        .stat-card p {
            color: #666;
            font-size: 14px;
        }
        .section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .section h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .action-btn {
            display: block;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .action-btn:hover {
            transform: translateY(-3px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f8f9fa;
            color: #333;
            font-weight: 600;
        }
        .game-title {
            font-weight: 600;
            color: #667eea;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <h1>👨‍🏫 Teacher Dashboard</h1>
            <div>
                <a href="{{ route('teacher.games') }}" style="margin-right: 10px;">Kelola Game</a>
                <a href="{{ route('teacher.logout') }}">Logout</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Selamat Datang, {{ $teacher->name }}! 👋</h2>
            <p>Kelola game edukasi dan pantau progress siswa Anda</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>{{ $stats['total_games'] }}</h3>
                <p>🎮 Total Game</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['total_questions'] }}</h3>
                <p>📝 Total Soal</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['templates_available'] }}</h3>
                <p>🎨 Template Tersedia</p>
            </div>
        </div>

        <div class="section">
            <h3>⚡ Quick Actions</h3>
            <div class="quick-actions">
                <a href="{{ route('teacher.games') }}" class="action-btn">🎮 Kelola Game</a>
                <a href="{{ route('teacher.games.create') }}" class="action-btn">➕ Buat Game Baru</a>
            </div>
        </div>

        <div class="section">
            <h3>📊 Statistik Siswa</h3>
            
            @if(count($gameAnalytics) > 0)
                @foreach($gameAnalytics as $data)
                    <div style="margin-bottom: 30px;">
                        <div class="game-title">🎮 {{ $data['game']->title }}</div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Orang Tua</th>
                                    <th>Skor</th>
                                    <th>Tanggal Main</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['sessions'] as $session)
                                <tr>
                                    <td>{{ $session->student->name }}</td>
                                    <td>{{ $session->student->class ?? '-' }}</td>
                                    <td>{{ $session->student->orangTua->name ?? '-' }}</td>
                                    <td><strong>{{ $session->score }}</strong></td>
                                    <td>{{ $session->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @else
                <div class="no-data">
                    <p>📭 Belum ada siswa yang memainkan game Anda</p>
                    <p style="font-size: 14px; margin-top: 10px;">Buat game baru dan bagikan ke siswa!</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
