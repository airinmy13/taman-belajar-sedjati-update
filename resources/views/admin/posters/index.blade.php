<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Poster - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; }
        .tab-btn { padding: 12px 25px; border: none; background: none; font-size: 16px; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.3s; }
        .tab-btn:hover { color: #667eea; }
        .tab-btn.active { color: #667eea; border-bottom-color: #667eea; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .poster-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .poster-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .poster-card:hover { transform: translateY(-5px); }
        .poster-img { height: 350px; overflow: hidden; position: relative; }
        .poster-img img { width: 100%; height: 100%; object-fit: cover; }
        .poster-info { padding: 15px; }
        .poster-title { font-weight: bold; margin-bottom: 5px; color: #333; }
        .poster-date { font-size: 12px; color: #64748b; margin-bottom: 15px; }
        
        .btn-add { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
        .btn-delete { width: 100%; padding: 8px; background: #fee2e2; color: #ef4444; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; transition: background 0.3s; }
        .btn-delete:hover { background: #fecaca; }

        .empty-state { text-align: center; padding: 50px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📸 Kelola Poster Harian</h1>
        <div><a href="{{ route('admin.dashboard') }}" style="color: white; text-decoration: none;">Dashboard</a></div>
    </div>

    <div class="container">
        <div class="header">
            <div>
                <h2>Daftar Poster</h2>
                <p style="color: #64748b;">Upload poster harian untuk siswa (Bahasa Arab & Inggris)</p>
            </div>
            <a href="{{ route('admin.posters.create') }}" class="btn-add">➕ Upload Poster Baru</a>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="tabs">
            <button class="tab-btn {{ $activeTab == 'arab' ? 'active' : '' }}" onclick="alert('TODO: Implement Tab Switcher JS')">🇸🇦 Poster Arab</button>
            <button class="tab-btn {{ $activeTab == 'inggris' ? 'active' : '' }}" onclick="alert('TODO: Implement Tab Switcher JS')">🇬🇧 Poster Inggris</button>
        </div>
        
        <!-- Karena saya malas copy paste JS, saya pakai script sederhana inline saja -->
        <script>
            document.write('<style>.tab-content { display: none; } .tab-content.active { display: block; }</style>');
        </script>

        <!-- TAB ARAB -->
        <div id="arab-content" class="tab-content {{ $activeTab == 'arab' ? 'active' : '' }}">
            @if($arabPosters->count() > 0)
                <div class="poster-grid">
                    @foreach($arabPosters as $poster)
                        <div class="poster-card">
                            <div class="poster-img">
                                <img src="{{ asset($poster->image) }}" alt="{{ $poster->title }}">
                            </div>
                            <div class="poster-info">
                                <div class="poster-title">{{ $poster->title }}</div>
                                <div class="poster-date">📅 {{ $poster->created_at->format('d M Y') }}</div>
                                <form action="{{ route('admin.posters.delete', $poster->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">🗑️ Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div style="font-size: 50px; margin-bottom: 20px;">🖼️</div>
                    <h3>Belum ada poster Bahasa Arab</h3>
                </div>
            @endif
        </div>

        <!-- TAB INGGRIS -->
        <div id="inggris-content" class="tab-content {{ $activeTab == 'inggris' ? 'active' : '' }}">
            @if($englishPosters->count() > 0)
                <div class="poster-grid">
                    @foreach($englishPosters as $poster)
                        <div class="poster-card">
                            <div class="poster-img">
                                <img src="{{ asset($poster->image) }}" alt="{{ $poster->title }}">
                            </div>
                            <div class="poster-info">
                                <div class="poster-title">{{ $poster->title }}</div>
                                <div class="poster-date">📅 {{ $poster->created_at->format('d M Y') }}</div>
                                <form action="{{ route('admin.posters.delete', $poster->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">🗑️ Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div style="font-size: 50px; margin-bottom: 20px;">🖼️</div>
                    <h3>Belum ada poster Bahasa Inggris</h3>
                </div>
            @endif
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach((tab, index) => {
            tab.onclick = () => {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));
                
                tab.classList.add('active');
                contents[index].classList.add('active');
            }
        });
    </script>
</body>
</html>
