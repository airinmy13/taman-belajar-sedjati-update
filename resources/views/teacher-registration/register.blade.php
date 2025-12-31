<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Guru - Platform Game Edukasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
        }
        .checkbox-item input {
            margin-right: 8px;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            cursor: pointer;
            user-select: none;
            font-size: 18px;
            color: #666;
            transition: color 0.3s;
        }
        .toggle-password:hover {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👨‍🏫 Pendaftaran Guru</h1>
        <p class="subtitle">Bergabunglah dengan Platform Game Edukasi</p>

        @if($errors->any())
        <div class="error">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('teacher.register.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">Nama Lengkap *</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" required value="{{ old('username') }}">
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="phone">No. Telepon *</label>
                <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}">
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required>
                    <span class="toggle-password" onclick="togglePassword('password')">
                        <svg class="eye-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password *</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    <span class="toggle-password" onclick="togglePassword('password_confirmation')">
                        <svg class="eye-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>Mata Pelajaran yang Diampu * (Pilih minimal 1)</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="Matematika" id="mtk">
                        <label for="mtk" style="margin: 0;">Matematika</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="Bahasa Indonesia" id="bind">
                        <label for="bind" style="margin: 0;">Bahasa Indonesia</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="Bahasa Inggris" id="bing">
                        <label for="bing" style="margin: 0;">Bahasa Inggris</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="Bahasa Arab" id="bar">
                        <label for="bar" style="margin: 0;">Bahasa Arab</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="IPA (Sains)" id="ipa">
                        <label for="ipa" style="margin: 0;">IPA (Sains)</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="IPS (Sosial)" id="ips">
                        <label for="ips" style="margin: 0;">IPS (Sosial)</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="Agama Islam" id="agama">
                        <label for="agama" style="margin: 0;">Agama Islam</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="Budaya" id="budaya">
                        <label for="budaya" style="margin: 0;">Budaya</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="subjects[]" value="Olahraga" id="or">
                        <label for="or" style="margin: 0;">Olahraga</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn">Daftar Sekarang</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('teacher.login') }}">Login di sini</a>
        </div>
    </div>
    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleContainer = passwordField.nextElementSibling;
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleContainer.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;
            } else {
                passwordField.type = "password";
                toggleContainer.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
            }
        }
    </script>
</body>
</html>
