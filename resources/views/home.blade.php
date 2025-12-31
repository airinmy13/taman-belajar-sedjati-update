<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>World Games Languages - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* RESET DASAR */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to bottom, #87ceeb 0%, #e0f7fa 100%);
      color: #2c3e50;
      overflow-x: hidden;
    }
    
    .password-wrapper { position: relative; }
    .password-wrapper input { padding-right: 45px !important; }
    .toggle-password { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #667eea; font-size: 18px; user-select: none; z-index: 10; }

    /* BACKGROUND AWAN BERGERAK */
    .clouds {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: -1;
    }

    .cloud {
      position: absolute;
      background: white;
      border-radius: 50%;
      opacity: 0.9;
      box-shadow: 0 0 30px rgba(255,255,255,0.8);
      animation: drift linear infinite;
    }

    .cloud1 { width: 300px; height: 100px; top: 15%; animation-duration: 120s; animation-delay: -20s; }
    .cloud2 { width: 250px; height: 80px; top: 30%; animation-duration: 140s; animation-delay: -40s; }
    .cloud3 { width: 400px; height: 120px; top: 45%; animation-duration: 160s; animation-delay: -60s; }
    .cloud4 { width: 200px; height: 70px; top: 60%; animation-duration: 130s; animation-delay: -10s; }
    .cloud5 { width: 350px; height: 110px; top: 10%; animation-duration: 150s; animation-delay: -80s; }

    @keyframes drift {
      0% { transform: translateX(100vw); }
      100% { transform: translateX(-100%); }
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    /* HEADER */
    header {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      color: #1e293b;
      padding: 20px 6%;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(148, 163, 184, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s ease;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .logo {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, #ffffff, #ffffff);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      font-weight: 800;
      color: white;
      box-shadow: 0 8px 24px rgba(59,130,246,0.3);
      transition: all 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05) rotate(5deg);
    }

    .logo-text {
      font-size: 1.6rem;
      font-weight: 800;
      color: #1e293b;
    }

    .subtitle {
      font-size: 0.95rem;
      color: #64748b;
      margin-top: 2px;
    }

    nav ul {
      list-style: none;
      display: flex;
      align-items: center;
      gap: 48px;
    }

    nav a {
      color: #1e293b;
      text-decoration: none;
      font-size: 1.1rem;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 12px;
      transition: all 0.3s ease;
      position: relative;
    }

    nav a:hover {
      color: #3b82f6;
      transform: translateY(-2px);
    }

    nav a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, #3b82f6, #1d4ed8);
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }

    nav a:hover::after {
      width: 80%;
    }

    .login-btn {
      background: #ffcc00;
      color: #1e293b; 
      padding: 14px 32px;
      border: none;
      border-radius: 50px;
      font-size: 1.05rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 8px 24px rgba(255,215,0,0.4);
      letter-spacing: 0.5px;
      position: relative;
      overflow: hidden;
    }

    .login-btn:hover {
      background: #FFEC8B;
      transform: translateY(-4px);
      box-shadow: 0 16px 32px rgba(255,215,0,0.6);
    }

    .login-btn:active {
      transform: translateY(-2px);
    }

    main {
      padding-top: 140px;
      position: relative;
      z-index: 1;
    }

    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 40px 8% 140px;
      min-height: 80vh;
      background: transparent;
    }

    .hero-content {
      max-width: 50%;
      background: rgba(255,255,255,0.85);
      padding: 40px 40px;
      margin: 10px;
      border-radius: 30px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      backdrop-filter: blur(8px);
    }

    .hero h1 {
      font-size: 3.8rem;
      margin-bottom: 28px;
      line-height: 1.15;
      color: #1e3a8a;
      font-weight: 800;
      background: linear-gradient(135deg, #1e3a8a, #3b82f6);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero p {
      font-size: 1.45rem;
      margin-bottom: 48px;
      margin-top: 40px;
      line-height: 1.7;
      color: #334155;
    }

    .hero-image {
      max-width: 45%;
      text-align: right;
    }

    .hero-image img {
      width: 100%;
      max-width: 570px;
      border-radius: 550px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }

    .hero-image img:hover {
      transform: scale(1.05);
      box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }

    .btn-primary {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      color: white;
      padding: 18px 44px;
      border: none;
      border-radius: 50px;
      font-size: 1.25rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 8px 24px rgba(59,130,246,0.4);
    }

    .btn-primary:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 40px rgba(59,130,246,0.5);
    }

    .games-section {
      padding: 120px 8% 140px;
      text-align: center;
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(12px);
      border-radius: 40px 50px 0 0;
      margin-top: -80px;
    }

    .games-section h2 {
      font-size: 3.2rem;
      margin-bottom: 20px;
      color: #1e3a8a;
      font-weight: 800;
      background: linear-gradient(135deg, #1e3a8a, #3b82f6);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .games-section p {
      font-size: 1.3rem;
      color: #334155;
      margin-bottom: 60px;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    .games-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .game-card {
      background: white;
      border-radius: 30px;
      padding: 40px 30px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.12);
      transition: all 0.4s ease;
      text-align: center;
      position: relative;
      overflow: hidden;
      border: 4px solid #FFD700;
    }

    .game-card:hover {
      transform: translateY(-15px) scale(1.03);
      box-shadow: 0 25px 60px rgba(0,0,0,0.2);
      border-color: #FFEC8B;
    }

    .card-icon {
      font-size: 4rem;
      margin-bottom: 20px;
      opacity: 0.9;
    }

    .game-card h3 {
      font-size: 1.8rem;
      margin-bottom: 16px;
      color: #1e293b;
    }

    .game-card p {
      font-size: 1.1rem;
      color: #64748b;
      margin-bottom: 30px;
    }

    .game-btn {
      background: #FFD700;
      color: #1e293b;
      padding: 14px 32px;
      border: none;
      border-radius: 50px;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(255,215,0,0.4);
    }

    .game-btn:hover {
      background: #FFEC8B;
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(255,215,0,0.6);
    }

    .btn-gamelain {
      display: block; 
      width: fit-content; 
      max-width: 400px; 
      margin: 40px auto 0 auto; 
      background: linear-gradient(135deg, #ffc756, #ffd608);
      color: rgb(0, 0, 0);
      padding: 18px 44px;
      border: none;
      border-radius: 50px;
      font-size: 1.25rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 8px 24px rgba(255,200,86,0.4);
      text-align: center; 
    }

    .btn-gamelain:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 40px rgba(255,200,86,0.5);
    }

    .parents-section {
      padding: 120px 8% 140px;
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(12px);
      border-radius: 50px 50px 0 0;
    }

    .parents-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 60px;
    }

    .parents-image {
      max-width: 50%;
      text-align: left;
    }

    .parents-image img {
      width: 100%;
      max-width: 550px;
      border-radius: 40px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }

    .parents-image img:hover {
      transform: scale(1.05);
    }

    .parents-text {
      max-width: 50%;
      background: rgba(255,255,255,0.9);
      padding: 40px 40px;
      border-radius: 30px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      backdrop-filter: blur(8px);
    }

    .parents-text h2 {
      font-size: 3rem;
      margin-bottom: 24px;
      color: #1e3a8a;
      font-weight: 800;
      background: linear-gradient(135deg, #1e3a8a, #3b82f6);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .parents-text p {
      font-size: 1.3rem;
      color: #334155;
      margin-bottom: 32px;
    }

    .parents-list {
      list-style: none;
      margin-bottom: 40px;
    }

    .parents-list li {
      font-size: 1.15rem;
      margin-bottom: 16px;
      padding-left: 30px;
      position: relative;
      color: #1e293b;
    }

    .parents-list li::before {
      content: '✔';
      position: absolute;
      left: 0;
      color: #3b82f6;
      font-weight: bold;
    }

    .btn-parents {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      color: white;
      padding: 18px 44px;
      border: none;
      border-radius: 50px;
      font-size: 1.25rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 8px 24px rgba(59,130,246,0.4);
    }

    .btn-parents:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 40px rgba(59,130,246,0.5);
    }

    @media (max-width: 1024px) {
      .hero {
        flex-direction: column;
        text-align: center;
        padding: 100px 5%;
      }
      .hero-content {
        max-width: 100%;
      }
      .hero-image {
        max-width: 70%;
        margin-top: 50px;
      }
      .hero h1 {
        font-size: 3rem;
      }
      .parents-content {
        flex-direction: column;
        text-align: center;
      }
      .parents-image, .parents-text {
        max-width: 100%;
      }
      .parents-text {
        text-align: left;
      }
      .parents-section {
        padding: 100px 5%;
      }
    }

    @media (max-width: 768px) {
      nav ul {
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
      }
      .login-btn {
        margin-top: 10px;
      }
      .parents-text h2 {
        font-size: 2.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="clouds">
    <div class="cloud cloud1"></div>
    <div class="cloud cloud2"></div>
    <div class="cloud cloud3"></div>
    <div class="cloud cloud4"></div>
    <div class="cloud cloud5"></div>
  </div>

  <header id="header">
    <div class="logo-container">
      <div class="logo">🌏</div>
      <div>
        <div class="logo-text">Platform Game Edukasi⭐</div>
        <div class="subtitle">Belajar Sambil Bermain</div>
      </div>
    </div>

    <nav>
      <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#games">Games</a></li>
        <li><a href="#parents">For Parents</a></li>
      </ul>
    </nav>

    <a href="#games" class="login-btn" style="text-decoration: none; display: inline-block;">Mulai Bermain</a>
  </header>

  <main>
    <section class="hero" id="home">
      <div class="hero-content">
        <h1>Belajar <br>Sambil Bermain Dengan Permainan Yang Seru!</h1>
        <p>Ayo bermain, belajar, dan menjelajahi dunia pengetahuan bersama!</p>
        <button class="btn-primary" onclick="location.href = '#games'">Mulai Bermain Sekarang</button>
      </div>

      <div class="hero-image">
        <img src="{{ asset('images/anakbelajar.jpg') }}" alt="Anak belajar">
      </div>
    </section>

    <section class="games-section" id="games">
      <h2><span style="display: inline-block; animation: bounce 2s infinite;">🚀</span> Petualangan Bahasa Seru</h2>
      <p>Jelajahi dunia kata dan kalimat baru di sini! ✨</p>

      @if(isset($officialGames) && count($officialGames) > 0)
        <div class="games-grid">
          @foreach($officialGames as $game)
            <div class="game-card" style="border-color: #3b82f6; position: relative;">
              <!-- Badge Kelas -->
              <div style="position: absolute; top: 15px; left: 15px; background: #dbeafe; color: #1e40af; padding: 5px 12px; border-radius: 15px; font-weight: bold; font-size: 0.8rem;">
                🎒 {{ $game->class_level ? 'Kelas ' . $game->class_level : 'Semua Kelas' }}
              </div>

              <div class="card-icon">
                @if($game->thumbnail)
                  <img src="{{ asset($game->thumbnail) }}" alt="{{ $game->title }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                @else
                  {{ $game->language == 'arab' ? '🕌' : '🇬🇧' }}
                @endif
              </div>
              <h3>{{ $game->title }}</h3>
              <p>{{ Str::limit($game->description, 100) }}</p>
              
              <div style="margin-bottom: 20px;"></div>

              <form action="{{ route('games.start', $game->slug) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="game-btn" style="background: #3b82f6; color: white; width: 100%;">🚀 Mulai Petualangan!</button>
              </form>
            </div>
          @endforeach
        </div>
      @else
        <p style="text-align: center; color: #666; margin-bottom: 50px;">Belum ada game official yang tersedia.</p>
      @endif

      <h2 style="margin-top: 80px; font-size: 2.5rem; color: #d97706;"><span style="display: inline-block; animation: bounce 2s infinite; animation-delay: 0.5s;">🎮</span> Zona Kreatif Mentor</h2>
      <p>Temukan game unik dan seru buatan Kakak Mentor! 🎮</p>

      @if(isset($mentorGames) && count($mentorGames) > 0)
        <div class="games-grid">
          @foreach($mentorGames as $game)
            <div class="game-card">
              <!-- Badge Kelas -->
              <div style="position: absolute; top: 15px; left: 15px; background: #fef9c3; color: #854d0e; padding: 5px 12px; border-radius: 15px; font-weight: bold; font-size: 0.8rem;">
                🎒 {{ $game->class_level ? 'Kelas ' . $game->class_level : 'Semua Kelas' }}
              </div>

              <div class="card-icon">
                @if($game->thumbnail)
                  <img src="{{ asset($game->thumbnail) }}" alt="{{ $game->title }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                @else
                  🎮
                @endif
              </div>
              <h3>{{ $game->title }}</h3>
              <p>{{ Str::limit($game->description, 100) }}</p>
              
              <div style="margin-bottom: 20px; font-size: 0.9rem; color: #78350f;">
                 Mentor: <strong>{{ $game->teacher->name ?? 'Hebat' }}</strong>
              </div>

              <form action="{{ route('games.start', $game->slug) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="game-btn" style="width: 100%;">🎮 Main Yuk!</button>
              </form>
            </div>
          @endforeach
        </div>
      @else
        <p style="text-align: center; color: #666;">Belum ada game mentor yang tersedia.</p>
      @endif

      <a href="{{ route('games.index') }}" class="btn-gamelain" style="text-decoration: none;">Lihat Semua Game</a>
    </section>

    <section class="games-section" style="background: linear-gradient(135deg, #caf0f8 0%, #ade8f4 100%); padding-top: 60px;">
      <h2>📸 Poster Edukasi Harian</h2>
      <p>Kosa kata baru setiap hari untukmu! (Arab & Inggris)</p>

      <div class="row justify-content-center mb-4">
        <div class="col-auto">
            <ul class="nav nav-pills" id="pills-tab" role="tablist" style="background: rgba(255,255,255,0.5); padding: 5px; border-radius: 50px;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4" id="pills-arab-tab" data-bs-toggle="pill" data-bs-target="#pills-arab" type="button" role="tab" style="font-weight: bold;">🇸🇦 Bahasa Arab</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4" id="pills-inggris-tab" data-bs-toggle="pill" data-bs-target="#pills-inggris" type="button" role="tab" style="font-weight: bold;">🇬🇧 Bahasa Inggris</button>
                </li>
            </ul>
        </div>
      </div>

      <div class="tab-content" id="pills-tabContent">
        <!-- Arab Posters -->
        <div class="tab-pane fade show active" id="pills-arab" role="tabpanel">
            @if(isset($arabPosters) && count($arabPosters) > 0)
                <div class="games-grid">
                    @foreach($arabPosters as $poster)
                        <div class="game-card" style="padding: 0; border: none; overflow: hidden;">
                            <img src="{{ asset($poster->image) }}" alt="{{ $poster->title }}" style="width: 100%; height: 250px; object-fit: cover;">
                            <div style="padding: 20px;">
                                <h3 style="font-size: 1.4rem;">{{ $poster->title }}</h3>
                                <p style="font-size: 0.95rem; margin-bottom: 10px;">{{ $poster->description }}</p>
                                <small class="text-muted">📅 {{ $poster->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center py-5 text-muted">Belum ada poster Bahasa Arab saat ini.</p>
            @endif
        </div>

        <!-- English Posters -->
        <div class="tab-pane fade" id="pills-inggris" role="tabpanel">
            @if(isset($englishPosters) && count($englishPosters) > 0)
                <div class="games-grid">
                    @foreach($englishPosters as $poster)
                        <div class="game-card" style="padding: 0; border: none; overflow: hidden;">
                            <img src="{{ asset($poster->image) }}" alt="{{ $poster->title }}" style="width: 100%; height: 250px; object-fit: cover;">
                            <div style="padding: 20px;">
                                <h3 style="font-size: 1.4rem;">{{ $poster->title }}</h3>
                                <p style="font-size: 0.95rem; margin-bottom: 10px;">{{ $poster->description }}</p>
                                <small class="text-muted">📅 {{ $poster->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center py-5 text-muted">Belum ada poster Bahasa Inggris saat ini.</p>
            @endif
        </div>
      </div>

      <!-- Tombol Lihat Semua Poster -->
      <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('posters.index') }}" style="display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 1.1rem; box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3); transition: all 0.3s;">
          📖 Lihat Semua Poster
        </a>
      </div>

    </section>

    <section class="parents-section" id="parents">
      <div class="parents-content">
        <div class="parents-image">
          <img src="{{ asset('images/family.jpg') }}" alt="Orang tua dan anak belajar bersama">
        </div>

        <div class="parents-text">
          <h2>Untuk Orang Tua: Belajar Jadi Mudah & Menyenangkan!</h2>
          <p>Kami paham kekhawatiran orang tua soal pendidikan anak. Dengan Platform Game Edukasi, anak belajar berbagai mata pelajaran dengan menyenangkan. Berikut beberapa manfaatnya:</p>

          <ul class="parents-list">
            <li><strong>Aman & Terawasi</strong> Aman untuk anak, anak-anak dapat belajar dengan baik</li>
            <li><strong>Belajar Tanpa Tekanan</strong> Game edukatif membuat anak belajar sambil bermain, bukan belajar formal.</li>
            <li><strong>Laporan Kemajuan</strong> Pantau perkembangan belajar anak secara real-time melalui login sebagai orang tua.</li>
            <li><strong>Fleksibel</strong> Bisa dimainkan kapan saja, di HP atau tablet.</li>
            <li><strong>Gratis</strong> Permainan disini semuanya gratis! dan materinya sesuai dengan apa yang anak anda pelajari!</li>
          </ul>

          <button class="btn-parents" onclick="showParentLoginModal()">Lihat Dashboard Orang Tua</button>
        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER -->
  <footer style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: white; padding: 60px 20px 30px; margin-top: 80px;">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 40px;">
        
        <!-- About Section -->
        <div>
          <h3 style="font-size: 1.5rem; margin-bottom: 20px; color: white;">🌟 World Games Languages</h3>
          <p style="line-height: 1.8; color: #e0e7ff; font-size: 0.95rem;">
            Platform game edukasi interaktif untuk membantu anak-anak belajar Bahasa Arab dan Inggris dengan cara yang menyenangkan.
          </p>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 style="font-size: 1.2rem; margin-bottom: 20px; color: white;">📌 Menu Cepat</h4>
          <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 12px;">
              <a href="{{ route('home') }}" style="color: #e0e7ff; text-decoration: none; transition: color 0.3s; font-weight: 500;">🏠 Beranda</a>
            </li>
            <li style="margin-bottom: 12px;">
              <a href="{{ route('posters.index') }}" style="color: #e0e7ff; text-decoration: none; transition: color 0.3s; font-weight: 500;">📚 Poster Edukasi</a>
            </li>
            <li style="margin-bottom: 12px;">
              <a href="{{ route('games.index') }}" style="color: #e0e7ff; text-decoration: none; transition: color 0.3s; font-weight: 500;">🎮 Semua Game</a>
            </li>
            <li style="margin-bottom: 12px;">
              <a href="{{ route('parent.login') }}" style="color: #e0e7ff; text-decoration: none; transition: color 0.3s; font-weight: 500;">👨‍👩‍👧 Dashboard Orang Tua</a>
            </li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h4 style="font-size: 1.2rem; margin-bottom: 20px; color: white;">📞 Hubungi Kami</h4>
          <p style="color: #e0e7ff; line-height: 1.8; font-size: 0.95rem;">
            📍 Desa Gajah, Bojonegoro, Jawa Timur<br>
            📧 Email: info@bimbelpados.com<br>
            📱 Telepon: +62 812-3456-7890
          </p>
        </div>
      </div>

      <!-- Copyright -->
      <div style="border-top: 2px solid rgba(255, 255, 255, 0.2); padding-top: 30px; text-align: center;">
        <p style="color: #e0e7ff; font-size: 0.95rem; margin: 0; font-weight: 500;">
          © 2026 Taman Belajar Sedjati. All rights reserved. | Belajar, Berkembang, Dan Berkarya Di Desa Gajah
        </p>
      </div>
    </div>
  </footer>

  <!-- Student Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 30px; border: none;">
        <div class="modal-header" style="background: linear-gradient(135deg, #ffcc00, #ffd608); border: none; padding: 2rem; border-radius: 30px 30px 0 0;">
          <h5 class="modal-title" style="color: #1e293b; font-size: 2rem; font-weight: 700; width: 100%; text-align: center;">
            🎮 Ayo Mulai Bermain!
          </h5>
        </div>
        <div class="modal-body" style="padding: 2.5rem;">
          @if(session('error'))
            <div class="alert alert-warning" style="background: #fff3cd; border: 2px solid #ffc107; border-radius: 15px; margin-bottom: 1.5rem; padding: 1rem;">
              <div style="font-size: 2rem; text-align: center; margin-bottom: 0.5rem;">😊</div>
              <div style="color: #856404; text-align: center; font-size: 1rem; line-height: 1.6;">
                {{ session('error') }}
              </div>
            </div>
          @endif
          
          <form action="{{ route('student.login') }}" method="POST">
            @csrf
            <div class="mb-4">
              <label class="form-label">📝 Siapa namamu?</label>
  <input type="text" class="form-control" name="nama_anak" required placeholder="Masukkan nama kamu..." value="{{ old('nama_anak') }}">
</div>

<div class="mb-4">
  <label class="form-label">🎓 Kamu kelas berapa?</label>
  <select class="form-select" name="kelas" required>
    <option value="">Pilih kelas...</option>
    <option value="1" {{ old('kelas') == '1' ? 'selected' : '' }}>Kelas 1</option>
    <option value="2" {{ old('kelas') == '2' ? 'selected' : '' }}>Kelas 2</option>
                <option value="3" {{ old('kelas') == '3' ? 'selected' : '' }}>Kelas 3</option>
                <option value="4" {{ old('kelas') == '4' ? 'selected' : '' }}>Kelas 4</option>
                <option value="5" {{ old('kelas') == '5' ? 'selected' : '' }}>Kelas 5</option>
                <option value="6" {{ old('kelas') == '6' ? 'selected' : '' }}>Kelas 6</option>
              </select>
            </div>

            <div class="d-grid gap-2">
              <button type="submit" class="btn-primary" style="width: 100%; font-size: 1.3rem; padding: 1rem;">
                🚀 Mulai Petualangan!
              </button>
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" 
                      style="border-radius: 50px; padding: 0.8rem; font-weight: 600;">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Parent Login Modal -->
  <div class="modal fade" id="parentLoginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 30px; border: none;">
        <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); border: none; padding: 2rem; border-radius: 30px 30px 0 0;">
          <h5 class="modal-title" style="color: white; font-size: 2rem; font-weight: 700; width: 100%; text-align: center;">
            👨‍👩‍👧 Login Orang Tua
          </h5>
        </div>
            <div class="modal-body" style="padding: 2.5rem;">
  <form action="{{ route('parent.login.post') }}" method="POST">
    @csrf
    <div class="mb-4">
      <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 1.2rem;">
        <span style="font-size: 2rem; margin-right: 0.5rem;">📧</span>Username Orang Tua
      </label>
      <input type="text" class="form-control" name="username" required 
             placeholder="Masukkan username Anda..."
             style="border-radius: 15px; padding: 1rem; border: 2px solid #E5E7EB; font-size: 1.1rem;">
    </div>
    
    <div class="mb-4">
      <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 1.2rem;">
        <span style="font-size: 2rem; margin-right: 0.5rem;">🔑</span>Kata Sandi
      </label>
      <div class="password-wrapper">
        <input type="password" id="parent_password" class="form-control" name="password" required 
               placeholder="Masukkan password..."
               style="border-radius: 15px; padding: 1rem; border: 2px solid #E5E7EB; font-size: 1.1rem;">
        <span class="toggle-password" onclick="togglePassword('parent_password', this)">👁</span>
      </div>
    </div>

    <div class="d-grid gap-2">
      <button type="submit" class="btn-parents" style="width: 100%; font-size: 1.3rem; padding: 1rem;">
        🚀 Lihat Progress Anak
      </button>
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" 
              style="border-radius: 50px; padding: 0.8rem; font-weight: 600;">
        Batal
      </button>
    </div>
  </form>
</div>
            


  <footer style="background: #1e3a8a; color: white; text-align: center; padding: 20px 0; font-size: 0.9rem; border-top: 3px solid #FFD700; position: relative; z-index: 999; margin-top: 50px; clear: both;">
    <p style="margin: 0;">© 2025 Platform Game Edukasi • by <span style="color: #FFD700; font-weight: bold;">Sedjati Flora Game ⭐</span></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePassword(inputId, icon) {
      const input = document.getElementById(inputId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '✕';
      } else {
        input.type = 'password';
        icon.textContent = '👁';
      }
    }
    
    function showLoginModal() {
      const modal = new bootstrap.Modal(document.getElementById('loginModal'));
      modal.show();
    }

    function showParentLoginModal() {
      const modal = new bootstrap.Modal(document.getElementById('parentLoginModal'));
      modal.show();
    }

    // Auto-show login modal if there's an error or show_login flag
    @if(session('error') || session('show_login'))
      document.addEventListener('DOMContentLoaded', function() {
        showLoginModal();
      });
    @endif

    window.addEventListener('scroll', () => {
      const header = document.getElementById('header');
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  </script>
</body>
</html>