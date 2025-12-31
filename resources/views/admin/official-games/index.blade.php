<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Bahasa Official - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        /* Tabs Style */
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; }
        .tab-btn { padding: 12px 25px; border: none; background: none; font-size: 16px; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.3s; }
        .tab-btn:hover { color: #667eea; }
        .tab-btn.active { color: #667eea; border-bottom-color: #667eea; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .game-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .game-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; display: flex; flex-direction: column; }
        .game-card:hover { transform: translateY(-5px); }
        .game-thumb { height: 180px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 50px; overflow: hidden; }
        .game-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .game-info { padding: 20px; flex-grow: 1; }
        .game-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #333; }
        .game-meta { display: flex; gap: 10px; margin-bottom: 15px; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-arab { background: #dbeafe; color: #1e40af; }
        .badge-inggris { background: #fee2e2; color: #991b1b; }
        
        .btn-add { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
        .btn-manage { display: block; width: 100%; padding: 10px; text-align: center; background: #f8fafc; color: #475569; text-decoration: none; border-top: 1px solid #e2e8f0; font-weight: 600; transition: background 0.3s; }
        .btn-manage:hover { background: #e2e8f0; }

        .empty-state { text-align: center; padding: 50px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🔤 Kelola Game Bahasa Official</h1>
        <div><a href="{{ route('admin.dashboard') }}" style="color: white; text-decoration: none;">Dashboard</a></div>
    </div>

    <div class="container">
        <div class="header">
            <div>
                <h2>Daftar Game Official</h2>
                <p style="color: #64748b;">Kelola game bahasa Arab dan Inggris untuk kurikulum</p>
            </div>
            <a href="{{ route('admin.official-games.create') }}" class="btn-add">➕ Tambah Game Official</a>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="tabs">
            <button class="tab-btn {{ $activeTab == 'arab' ? 'active' : '' }}" onclick="switchTab('arab')">🇸🇦 Bahasa Arab</button>
            <button class="tab-btn {{ $activeTab == 'inggris' ? 'active' : '' }}" onclick="switchTab('inggris')">🇬🇧 Bahasa Inggris</button>
        </div>

        <!-- TAB ARAB -->
        <div id="arab" class="tab-content {{ $activeTab == 'arab' ? 'active' : '' }}">
            @if($arabicGames->count() > 0)
                <div class="game-grid">
                    @foreach($arabicGames as $game)
                        @include('admin.official-games.card', ['game' => $game, 'lang' => 'arab'])
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div style="font-size: 50px; margin-bottom: 20px;">🏜️</div>
                    <h3>Belum ada game Bahasa Arab</h3>
                    <p>Silakan tambah game baru untuk memulai.</p>
                </div>
            @endif
        </div>

        <!-- TAB INGGRIS -->
        <div id="inggris" class="tab-content {{ $activeTab == 'inggris' ? 'active' : '' }}">
            @if($englishGames->count() > 0)
                <div class="game-grid">
                    @foreach($englishGames as $game)
                        @include('admin.official-games.card', ['game' => $game, 'lang' => 'inggris'])
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div style="font-size: 50px; margin-bottom: 20px;">🏰</div>
                    <h3>Belum ada game Bahasa Inggris</h3>
                    <p>Silakan tambah game baru untuk memulai.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(tabId) {
            // Remove active class from buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            // Add active class to selected tab
            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
