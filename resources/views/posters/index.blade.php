<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poster Edukasi Harian - Platform Game Edukasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container { 
            max-width: 1400px; 
            margin: 0 auto; 
        }
        
        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }
        
        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .tabs {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .tab-btn {
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255,255,255,0.2);
            color: white;
            backdrop-filter: blur(10px);
        }
        
        .tab-btn.active {
            background: white;
            color: #667eea;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .tab-btn:hover {
            transform: translateY(-2px);
        }
        
        .poster-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .poster-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }
        
        .poster-card:hover {
            transform: translateY(-10px);
        }
        
        .poster-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            cursor: pointer;
        }
        
        .poster-info {
            padding: 20px;
        }
        
        .poster-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        
        .poster-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: rgba(255,255,255,0.9);
            border-radius: 20px;
            color: #666;
        }
        
        .empty-state-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 40px;
        }
        
        .back-link a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 12px 30px;
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            backdrop-filter: blur(10px);
            display: inline-block;
            transition: all 0.3s;
        }
        
        .back-link a:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        /* Modal untuk zoom gambar */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
            justify-content: center;
            align-items: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }
        
        .close-modal {
            position: absolute;
            top: 20px;
            right: 40px;
            color: white;
            font-size: 3rem;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Poster Edukasi Harian</h1>
            <p>Kosa kata baru setiap hari untukmu! (Arab & Inggris)</p>
        </div>
        
        <div class="tabs">
            <button class="tab-btn {{ request('tab') == 'inggris' ? 'active' : (request('tab') ? '' : 'active') }}" 
                    onclick="window.location.href='{{ route('posters.index', ['tab' => 'arab']) }}'">
                🇸🇦 Bahasa Arab
            </button>
            <button class="tab-btn {{ request('tab') == 'inggris' ? 'active' : '' }}" 
                    onclick="window.location.href='{{ route('posters.index', ['tab' => 'inggris']) }}'">
                🇬🇧 Bahasa Inggris
            </button>
        </div>
        
        @php
            $activeTab = request('tab', 'arab');
            $posters = \App\Models\Poster::where('category', $activeTab)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();
        @endphp
        
        @if($posters->count() > 0)
            <div class="poster-grid">
                @foreach($posters as $poster)
                    <div class="poster-card">
                        <img src="{{ asset($poster->image) }}" 
                             alt="{{ $poster->title }}" 
                             class="poster-image"
                             onclick="openModal('{{ asset($poster->image) }}')">
                        <div class="poster-info">
                            <div class="poster-title">{{ $poster->title }}</div>
                            @if($poster->description)
                                <div class="poster-description">{{ $poster->description }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h2>Belum Ada Poster</h2>
                <p>Poster {{ $activeTab == 'arab' ? 'Bahasa Arab' : 'Bahasa Inggris' }} akan segera hadir!</p>
            </div>
        @endif
        
        <div class="back-link">
            <a href="{{ route('home') }}">← Kembali ke Beranda</a>
        </div>
    </div>
    
    <!-- Modal untuk zoom gambar -->
    <div class="modal" id="imageModal" onclick="closeModal()">
        <span class="close-modal">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>
    
    <script>
        function openModal(imageSrc) {
            document.getElementById('imageModal').classList.add('active');
            document.getElementById('modalImage').src = imageSrc;
        }
        
        function closeModal() {
            document.getElementById('imageModal').classList.remove('active');
        }
    </script>
</body>
</html>
