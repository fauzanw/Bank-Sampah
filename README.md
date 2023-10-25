# Panduan Instalasi

### Langkah 1: Clone Repository
git clone https://github.com/fauzanw/Bank-Sampah

### Langkah 2: Install Dependencies
composer install

### Langkah 3: Generate App Key
php artisan key:generate

### Langkah 4: Konfigurasi Lingkungan
Salin file .env.example menjadi .env dan sesuaikan pengaturan database.

### Langkah 5: Menjalankan Seeder Database
php artisan db:seed

## Informasi Login Admin
Untuk login sebagai admin, sebagai berikut :
Email: admin@gmail.com 
Password: 12345678