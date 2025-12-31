# 📦 Panduan Instalasi Lengkap - Taman Belajar Sedjati

## Persiapan Server

### Requirement Minimum
- **PHP:** 8.1 atau lebih tinggi
- **MySQL:** 5.7 atau MariaDB 10.3+
- **Composer:** Latest version
- **Node.js:** 16.x atau lebih tinggi
- **NPM:** 8.x atau lebih tinggi
- **Web Server:** Apache 2.4+ atau Nginx 1.18+
- **RAM:** Minimum 512MB (Recommended 1GB+)
- **Storage:** Minimum 500MB

### Extension PHP yang Diperlukan
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
- Fileinfo
- GD (untuk image processing)

## Instalasi di Localhost (Development)

### 1. Install Laragon/XAMPP/WAMP
Jika belum punya local server, install salah satu:
- **Laragon** (Recommended): https://laragon.org/download/
- **XAMPP**: https://www.apachefriends.org/
- **WAMP**: https://www.wampserver.com/

### 2. Clone Project
```bash
cd C:\laragon\www  # atau C:\xampp\htdocs
git clone https://github.com/airinmy13/taman-belajar-sedjati.git
cd taman-belajar-sedjati
```

### 3. Install Composer Dependencies
```bash
composer install
```

Jika error, coba:
```bash
composer install --ignore-platform-reqs
```

### 4. Install NPM Dependencies
```bash
npm install
```

### 5. Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### 6. Konfigurasi Database

Buat database baru:
```sql
CREATE DATABASE game_edukasi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=game_edukasi
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Migration & Seeder
```bash
php artisan migrate:fresh --seed
```

Ini akan membuat:
- Tabel database
- Super Admin default
- Sample data (optional)

### 8. Create Storage Link
```bash
php artisan storage:link
```

### 9. Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 10. Run Development Server
```bash
php artisan serve
```

Akses: http://127.0.0.1:8000

## Instalasi di Shared Hosting (Production)

### 1. Upload Files
Upload semua file KECUALI:
- `.env` (buat baru di server)
- `node_modules/` (tidak perlu)
- `.git/` (optional)

### 2. Setup Database
- Buat database di cPanel/Plesk
- Import file SQL atau run migration via SSH

### 3. Konfigurasi .env
Buat file `.env` baru di root folder:
```env
APP_NAME="Taman Belajar Sedjati"
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Run Migration (via SSH)
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 6. Set Permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 7. Setup .htaccess
Pastikan file `public/.htaccess` ada dan berisi:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 8. Point Domain ke /public
Di cPanel, set Document Root ke folder `public/`

## Instalasi di VPS (Ubuntu/Debian)

### 1. Update System
```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Install PHP 8.1
```bash
sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd -y
```

### 3. Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 4. Install MySQL
```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation
```

### 5. Install Nginx
```bash
sudo apt install nginx -y
```

### 6. Clone Project
```bash
cd /var/www
sudo git clone https://github.com/airinmy13/taman-belajar-sedjati.git
cd taman-belajar-sedjati
```

### 7. Install Dependencies
```bash
sudo composer install --optimize-autoloader --no-dev
```

### 8. Setup Environment
```bash
sudo cp .env.example .env
sudo php artisan key:generate
```

### 9. Configure Nginx
```bash
sudo nano /etc/nginx/sites-available/taman-belajar
```

Paste:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/taman-belajar-sedjati/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/taman-belajar /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 10. Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/taman-belajar-sedjati
sudo chmod -R 755 /var/www/taman-belajar-sedjati/storage
sudo chmod -R 755 /var/www/taman-belajar-sedjati/bootstrap/cache
```

### 11. Run Migration
```bash
sudo php artisan migrate --force
sudo php artisan db:seed --force
sudo php artisan storage:link
```

### 12. Setup SSL (Optional)
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com
```

## Troubleshooting

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [1045] Access denied"
Cek konfigurasi database di `.env`

### Error: "The stream or file could not be opened"
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Error: "Class not found"
```bash
composer dump-autoload
```

### Images tidak muncul
```bash
php artisan storage:link
```

### CSS/JS tidak load
```bash
npm run build
php artisan optimize:clear
```

## Maintenance

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### Backup Database
```bash
mysqldump -u root -p game_edukasi > backup_$(date +%Y%m%d).sql
```

### Update dari Git
```bash
git pull origin main
composer install
php artisan migrate
php artisan optimize:clear
```

## Support

Jika mengalami masalah, hubungi:
- 📧 Email: info@bimbelpados.com
- 📱 WhatsApp: +62 812-3456-7890

---

**Selamat menggunakan Taman Belajar Sedjati! 🎉**
