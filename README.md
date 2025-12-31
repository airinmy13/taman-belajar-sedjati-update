# 🎮 Taman Belajar Sedjati - Platform Game Edukasi

Platform game edukasi interaktif berbasis web untuk membantu siswa SD (Kelas 1-6) belajar Bahasa Arab dan Bahasa Inggris dengan cara yang menyenangkan.

## 📋 Deskripsi

Taman Belajar Sedjati adalah platform pembelajaran digital yang menggabungkan game interaktif, poster edukasi, dan sistem manajemen pembelajaran untuk siswa, orang tua, guru/mentor, dan admin.

### 🌟 Fitur Utama

#### 👨‍💼 Super Admin
- Dashboard dengan statistik lengkap
- Manajemen Official Games (game resmi platform)
- Manajemen Mentor/Teacher (approve/reject)
- Manajemen Siswa & Orang Tua
- Manajemen Poster Edukasi (Arab & Inggris)
- Manajemen Jadwal Belajar
- View-only access ke game mentor

#### 👨‍🏫 Teacher/Mentor
- Dashboard pribadi dengan statistik game
- Buat & kelola game sendiri
- Template game: Matching, Multiple Choice, Fill Blank, Custom Code
- Manajemen soal/pertanyaan per game
- Target kelas untuk setiap game (Kelas 1-6 atau Semua Kelas)

#### 👨‍👩‍👧 Orang Tua
- Dashboard untuk monitor progress anak
- Lihat game yang dimainkan anak
- Lihat skor & hasil belajar
- Akses jadwal belajar anak

#### 🧒 Siswa
- Akses game sesuai kelas
- Filter otomatis game berdasarkan tingkat kelas
- Lihat poster edukasi
- Tracking progress & skor
- Game interaktif dengan berbagai template

## 🚀 Instalasi

### Requirement
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)
- Web Server (Apache/Nginx)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/airinmy13/taman-belajar-sedjati.git
cd taman-belajar-sedjati
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=game_edukasi
DB_USERNAME=root
DB_PASSWORD=
```

5. **Buat Database**
```bash
mysql -u root -p
CREATE DATABASE game_edukasi;
exit;
```

6. **Run Migration & Seeder**
```bash
php artisan migrate
php artisan db:seed
```

7. **Create Storage Link**
```bash
php artisan storage:link
```

8. **Compile Assets (Optional)**
```bash
npm run build
```

9. **Run Development Server**
```bash
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

## 🔑 Default Credentials

### Super Admin
- **URL:** `/admin/login`
- **Username:** `superadmin`
- **Password:** `password123`

### Teacher/Mentor
- **URL:** `/teacher/login`
- **Username:** (setelah registrasi & approval)
- **Password:** (yang didaftarkan)

### Parent
- **URL:** `/parent/login`
- **Username:** (setelah registrasi & approval)
- **Password:** (yang didaftarkan)

### Student
- **Login:** Langsung di home page
- **Username:** Nama siswa (dibuat oleh admin)
- **Password:** (dibuat oleh admin)

## 📁 Struktur Project

```
taman-belajar-sedjati/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── TeacherController.php
│   │   │   ├── ParentController.php
│   │   │   ├── StudentController.php
│   │   │   ├── GameController.php
│   │   │   └── ...
│   │   └── Middleware/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── images/
│   │   ├── games/
│   │   ├── posters/
│   │   └── questions/
│   └── js/
├── resources/
│   └── views/
│       ├── admin/
│       ├── teacher/
│       ├── parent/
│       ├── game/
│       └── home.blade.php
└── routes/
    └── web.php
```

## 🎮 Cara Menggunakan

### Untuk Admin

1. Login di `/admin/login`
2. Kelola Official Games di menu "Game Resmi"
3. Approve mentor di menu "Daftar Mentor"
4. Upload poster di menu "Poster"
5. Buat jadwal di menu "Jadwal"

### Untuk Teacher/Mentor

1. Registrasi di `/teacher/register`
2. Tunggu approval dari Super Admin
3. Login di `/teacher/login`
4. Buat game baru dengan template yang tersedia
5. Tambahkan soal/pertanyaan untuk game
6. Set target kelas untuk game

### Untuk Orang Tua

1. Registrasi di `/parent/register`
2. Tunggu approval dari Admin
3. Login di `/parent/login`
4. Monitor progress anak di dashboard

### Untuk Siswa

1. Login di home page dengan username & password
2. Pilih game sesuai kelas
3. Mainkan game dan kumpulkan skor
4. Lihat poster edukasi

## 🛠️ Teknologi yang Digunakan

- **Framework:** Laravel 10
- **Frontend:** Blade Templates, Vanilla JavaScript
- **Database:** MySQL
- **Styling:** Custom CSS dengan gradient modern
- **Icons:** Emoji & Unicode

## 📝 Fitur Game Templates

### 1. Matching Game
Pasangkan kata dengan terjemahan/pasangannya

### 2. Multiple Choice
Pilihan ganda dengan gambar/teks

### 3. Fill in the Blank
Isi kata yang hilang

### 4. Custom Code
Buat game sendiri dengan HTML/CSS/JS

## 🎨 Customization

### Mengubah Warna Tema
Edit file `resources/views/home.blade.php` dan cari section `<style>` untuk mengubah gradient dan warna.

### Menambah Template Game Baru
1. Tambahkan option di `resources/views/admin/games/create.blade.php`
2. Update validation di `AdminController::storeGame()`
3. Buat view template di `resources/views/game/`

## 📞 Kontak

**Taman Belajar Sedjati**
- 📍 Desa Gajah, Bojonegoro, Jawa Timur
- 📧 Email: info@bimbelpados.com
- 📱 Telepon: +62 812-3456-7890

## 📄 License

© 2026 Taman Belajar Sedjati. All rights reserved.

Belajar, Berkembang, Dan Berkarya Di Desa Gajah

---

**Dibuat dengan ❤️ untuk anak-anak Indonesia**
