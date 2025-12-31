<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Orang Tua - Platform Game Edukasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            font-size: 24px;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-light {
            background: white;
            color: #667eea;
        }

        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,255,255,0.3);
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .welcome-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .welcome-card h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
        }

        .children-section {
            margin-bottom: 30px;
        }

        .child-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .child-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .child-header h3 {
            color: #333;
            font-size: 22px;
        }

        .child-meta {
            display: flex;
            gap: 15px;
            font-size: 14px;
            color: #666;
        }

        .sessions-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sessions-table th {
            background: #f9fafb;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .sessions-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .sessions-table tr:hover {
            background: #f9fafb;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>👨‍👩‍👧‍👦 Dashboard Orang Tua</h1>
        <div class="navbar-user">
            <span>Halo, {{ $parent->parent_name }}!</span>
            <a href="{{ route('parent.logout') }}" class="btn btn-light">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h2>Selamat Datang, {{ $parent->gender == 'L' ? 'Ayah' : 'Bunda' }} {{ $parent->parent_name }}! 👋</h2>
            <p style="color: #666;">Pantau perkembangan belajar anak-anak Anda di sini</p>
        </div>

        {{-- Jadwal Les Anak --}}
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px;">
                <span>📅</span> Jadwal Les Anak
            </h2>
            
            @if($schedules->count() > 0)
                <div style="display: grid; gap: 15px;">
                    @foreach($schedules as $schedule)
                        <div style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; transition: all 0.3s; background: #f9fafb;">
                            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 15px;">
                                <div style="flex: 1; min-width: 200px;">
                                    <div style="font-weight: 600; color: #667eea; font-size: 16px; margin-bottom: 8px;">
                                        👶 {{ $schedule->student->name }}
                                    </div>
                                    <div style="color: #666; font-size: 14px; margin-bottom: 5px;">
                                        📆 {{ $schedule->day }}
                                    </div>
                                    <div style="color: #666; font-size: 14px; margin-bottom: 5px;">
                                        🕐 {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}
                                    </div>
                                    <div style="color: #667eea; font-weight: 500; font-size: 14px;">
                                        👨‍🏫 Mentor: {{ $schedule->mentor }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: #999;">
                    <div style="font-size: 48px; margin-bottom: 15px;">📅</div>
                    <p style="font-size: 16px;">Belum ada jadwal les yang terjadwal</p>
                </div>
            @endif
        </div>

        <h2 style="margin-bottom: 20px; color: #333;">📊 Statistik Keseluruhan</h2>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Anak</h3>
                <div class="number">{{ $students->count() }}</div>
            </div>
            <div class="stat-card">
                <h3>Game Dimainkan</h3>
                <div class="number">{{ $totalGamesPlayed }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Poin</h3>
                <div class="number">{{ $totalScore }}</div>
            </div>
            <div class="stat-card">
                <h3>Akurasi Keseluruhan</h3>
                <div class="number">{{ $overallAccuracy }}%</div>
            </div>
        </div>

        <h2 style="margin-bottom: 20px; color: #333;">👶 Progress Per Anak</h2>

        <div class="children-section">
            @forelse($students as $student)
                <div class="child-card">
                    <div class="child-header">
                        <div>
                            <h3>{{ $student->nama_anak }}</h3>
                            <div class="child-meta">
                                <span>🎓 Kelas {{ $student->kelas }}</span>
                                <span>🎮 {{ $allSessions[$student->id]->count() }} game dimainkan</span>
                            </div>
                        </div>
                    </div>

                    @if($allSessions[$student->id]->count() > 0)
                        <table class="sessions-table">
                            <thead>
                                <tr>
                                    <th>Game</th>
                                    <th>Tanggal</th>
                                    <th>Soal</th>
                                    <th>Benar</th>
                                    <th>Akurasi</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allSessions[$student->id] as $session)
                                    <tr>
                                        <td><strong>{{ $session->game->title }}</strong></td>
                                        <td>{{ $session->completed_at->format('d M Y, H:i') }}</td>
                                        <td>{{ $session->total_questions }}</td>
                                        <td>{{ $session->correct_answers }}</td>
                                        <td>
                                            <span class="badge {{ $session->accuracy >= 80 ? 'badge-success' : ($session->accuracy >= 60 ? 'badge-warning' : 'badge-danger') }}">
                                                {{ $session->accuracy }}%
                                            </span>
                                        </td>
                                        <td><strong>{{ $session->total_score }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">🎮</div>
                            <p>{{ $student->nama_anak }} belum bermain game apapun</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="child-card">
                    <div class="empty-state">
                        <div class="empty-state-icon">👶</div>
                        <p>Belum ada data anak terdaftar</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>