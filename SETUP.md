# 🚀 Quick Setup Guide - Taman Belajar Sedjati

## Untuk Teman yang Download ZIP dari GitHub

Ikuti langkah-langkah ini dengan TELITI:

---

## 📋 Langkah 1: Extract ZIP

1. Extract file ZIP ke folder web server:
   - **Laragon:** `C:\laragon\www\taman-belajar-sedjati`
   - **XAMPP:** `C:\xampp\htdocs\taman-belajar-sedjati`
   - **WAMP:** `C:\wamp\www\taman-belajar-sedjati`

---

## 📋 Langkah 2: Install Dependencies

Buka **Command Prompt** atau **Terminal** di folder project, lalu jalankan:

```bash
composer install
```

**Jika error**, coba:
```bash
composer install --ignore-platform-reqs
```

---

## 📋 Langkah 3: Setup Environment

1. **Copy file .env.example menjadi .env:**
```bash
copy .env.example .env
```

2. **Generate Application Key:**
```bash
php artisan key:generate
```

---

## 📋 Langkah 4: Buat Database

1. Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
2. Klik **"New"** di sidebar kiri
3. Buat database baru dengan nama: **`game_edukasi`**
4. Collation: **`utf8mb4_unicode_ci`**
5. Klik **"Create"**

---

## 📋 Langkah 5: Konfigurasi Database

Edit file **`.env`** di folder project:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=game_edukasi
DB_USERNAME=root
DB_PASSWORD=
```

**PENTING:** 
- Jika pakai password MySQL, isi `DB_PASSWORD=password_anda`
- Jika tidak pakai password, biarkan kosong

---

## 📋 Langkah 6: Run Migration & Seeder

**INI LANGKAH PALING PENTING!**

Jalankan command ini untuk membuat tabel dan akun Super Admin:

```bash
php artisan migrate:fresh --seed
```

**Perintah ini akan:**
- ✅ Membuat semua tabel database
- ✅ Membuat akun Super Admin
- ✅ Membuat akun Regular Admin

---

## 📋 Langkah 7: Create Storage Link

```bash
php artisan storage:link
```

---

## 📋 Langkah 8: Jalankan Server

```bash
php artisan serve
```

Buka browser dan akses: **http://127.0.0.1:8000**

---

## 🔑 DEFAULT CREDENTIALS

### Super Admin
- **URL Login:** `http://127.0.0.1:8000/admin/login`
- **Username:** `superadmin`
- **Password:** `superadmin123`

### Regular Admin
- **URL Login:** `http://127.0.0.1:8000/admin/login`
- **Username:** `admin`
- **Password:** `admin123`

---

## ❌ Troubleshooting

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: "Access denied for user 'root'@'localhost'"
- Cek username & password MySQL di file `.env`
- Pastikan MySQL sudah running

### Error: "Base table or view not found"
```bash
php artisan migrate:fresh --seed
```

### Login Super Admin tidak bisa
**PASTI karena belum run seeder!** Jalankan:
```bash
php artisan db:seed --class=AdminSeeder
```

Atau run ulang semua:
```bash
php artisan migrate:fresh --seed
```

### Images tidak muncul
```bash
php artisan storage:link
```

### Halaman blank/error 500
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Atau di Windows:
- Klik kanan folder `storage` → Properties → Security
- Berikan Full Control untuk semua users

---

## 📝 Checklist Setup

Pastikan semua langkah ini sudah dilakukan:

- [ ] Extract ZIP ke folder web server
- [ ] `composer install` berhasil
- [ ] File `.env` sudah dibuat dari `.env.example`
- [ ] `php artisan key:generate` sudah dijalankan
- [ ] Database `game_edukasi` sudah dibuat
- [ ] File `.env` sudah dikonfigurasi dengan benar
- [ ] **`php artisan migrate:fresh --seed` sudah dijalankan** ← PENTING!
- [ ] `php artisan storage:link` sudah dijalankan
- [ ] Server sudah running dengan `php artisan serve`
- [ ] Bisa login dengan username: `superadmin` password: `superadmin123`

---

## 🎯 Jika Masih Tidak Bisa Login

1. **Pastikan sudah run seeder:**
```bash
php artisan db:seed --class=AdminSeeder
```

2. **Cek apakah akun Super Admin ada di database:**
   - Buka phpMyAdmin
   - Pilih database `game_edukasi`
   - Klik tabel `admins`
   - Lihat apakah ada data dengan username `superadmin`

3. **Jika tabel `admins` kosong, run seeder lagi:**
```bash
php artisan db:seed --class=AdminSeeder
```

4. **Jika masih error, reset semua:**
```bash
php artisan migrate:fresh --seed
```

---

## 📞 Butuh Bantuan?

Jika masih ada masalah, hubungi:
- 📧 Email: info@bimbelpados.com
- 📱 WhatsApp: +62 812-3456-7890

---

**Selamat menggunakan Taman Belajar Sedjati! 🎉**
