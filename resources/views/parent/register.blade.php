<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Orang Tua - Game Edukasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .container { max-width: 600px; width: 100%; }
        .card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        h1 { color: #333; margin-bottom: 10px; text-align: center; }
        .subtitle { text-align: center; color: #666; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        input, select { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: border-color 0.3s; }
        input:focus, select:focus { outline: none; border-color: #667eea; }
        .radio-group { display: flex; gap: 20px; }
        .radio-group label { display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal; }
        .radio-group input[type="radio"] { width: auto; }
        .btn { width: 100%; padding: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 16px; font-weight: bold; cursor: pointer; transition: transform 0.3s; }
        .btn:hover { transform: translateY(-2px); }
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #667eea; text-decoration: none; }
        .section-title { background: #f0f4ff; padding: 10px 15px; border-radius: 8px; margin: 20px 0 15px 0; color: #667eea; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>👨‍👩‍👧‍👦 Pendaftaran Orang Tua</h1>
            <p class="subtitle">Daftarkan diri Anda dan anak Anda untuk mengakses game edukasi</p>

            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    ❌ Terdapat kesalahan:
                    <ul style="margin-top: 10px; margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('parent.register.submit') }}" method="POST">
                @csrf

                <div class="section-title">📋 Data Orang Tua</div>

                <div class="form-group">
                    <label for="parent_name">Nama Lengkap Orang Tua *</label>
                    <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Budi Santoso">
                </div>

                <div class="form-group">
                    <label for="username">Username (untuk login) *</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required placeholder="Contoh: budi123">
                    <small style="color: #666; font-size: 12px;">Username akan digunakan untuk login</small>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter" style="padding-right: 45px;">
                        <span onclick="togglePassword()" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; user-select: none; font-size: 18px;">👁</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com">
                    <small style="color: #666; font-size: 12px;">Email untuk notifikasi dan reset password</small>
                </div>

                <div class="form-group">
                    <label for="phone">No. HP/WhatsApp *</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="08123456789">
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin *</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="L" {{ old('gender') == 'L' ? 'checked' : '' }} required>
                            <span>👨 Laki-laki (Ayah)</span>
                        </label>
                        <label>
                            <input type="radio" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }} required>
                            <span>👩 Perempuan (Bunda)</span>
                        </label>
                    </div>
                </div>

                <div class="section-title">👶 Data Anak</div>

                <div class="form-group">
                    <label for="child_name">Nama Lengkap Anak *</label>
                    <input type="text" id="child_name" name="child_name" value="{{ old('child_name') }}" required placeholder="Contoh: Ani Budiarti">
                </div>

                <div class="form-group">
                    <label for="child_class">Kelas Anak *</label>
                    <input type="text" id="child_class" name="child_class" value="{{ old('child_class') }}" required placeholder="Contoh: 4 SD">
                </div>

                <button type="submit" class="btn">📝 Daftar Sekarang</button>
            </form>

            <div class="back-link">
                <a href="{{ route('home') }}">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = event.target;
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '✕';
            } else {
                input.type = 'password';
                icon.textContent = '👁';
            }
        }
    </script>
</body>
</html>
