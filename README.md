# CIMB Niaga Project

Proyek ini adalah sistem berbasis microservices yang terdiri dari tiga layanan (services) terpisah: **Login**, **Wealth**, dan **Transfer**. Setiap layanan dibangun menggunakan Laravel dan berkomunikasi satu sama lain.

## Prasyarat
Pastikan Anda sudah menginstal aplikasi berikut di sistem Anda:
- PHP (minimal versi 8.1+)
- Composer
- Node.js & npm (untuk frontend / Vite)
- MySQL (atau database pilihan lain)
- Git

## Cara Clone Repository
Untuk memulai, clone repository ke komputer lokal Anda:

```bash
git clone <URL_REPOSITORY_ANDA>
cd "CIMB PROJECT"
```

## Struktur Proyek
Di dalam repositori ini, terdapat tiga direktori utama yang merupakan microservice mandiri:
- `Login` (Berjalan di Port 8001)
- `Wealth` (Berjalan di Port 8002)
- `Transfer` (Berjalan di Port 8003)

## Cara Setup & Menjalankan Proyek

Lakukan langkah-langkah di bawah ini untuk **setiap** layanan (`Login`, `Wealth`, `Transfer`):

### 1. Masuk ke Direktori Layanan
Buka terminal dan masuk ke folder layanan:
```bash
# Contoh untuk layanan Login:
cd Login
```

### 2. Install Dependensi
Install dependensi PHP menggunakan Composer dan dependensi JavaScript menggunakan npm:
```bash
composer install
npm install
```

### 3. Setup File Environment (.env)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Setelah disalin, buka file `.env` dan pastikan konfigurasi database sudah sesuai dengan pengaturan lokal Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cimb_login  # Ubah sesuai layanan: cimb_wealth atau cimb_transfer
DB_USERNAME=root
DB_PASSWORD=            # Isi password jika ada
```

### 4. Generate Application Key
Jalankan perintah berikut untuk meng-generate application key untuk Laravel:
```bash
php artisan key:generate
```

### 5. Buat Database dan Jalankan Migrasi
Pastikan Anda sudah membuat database kosong (misal: `cimb_login`, `cimb_wealth`, `cimb_transfer`) di MySQL Anda. Lalu jalankan migrasi database:
```bash
php artisan migrate
```
(Jika ada seeder, Anda juga dapat menjalankan `php artisan migrate --seed`)

### 6. Jalankan Server Development
Setiap layanan membutuhkan dua server yang berjalan secara bersamaan (satu untuk backend PHP dan satu untuk frontend Vite/npm).

Buka terminal pertama untuk menjalankan backend:
```bash
# Pastikan menggunakan port yang tepat untuk tiap layanan
php artisan serve --port=8001  # Untuk Login
# php artisan serve --port=8002  # Untuk Wealth
# php artisan serve --port=8003  # Untuk Transfer
```

Buka terminal kedua (di direktori layanan yang sama) untuk menjalankan frontend Vite:
```bash
npm run dev
```

## Catatan Penting
- Karena proyek ini menggunakan arsitektur microservices, pastikan **semua layanan (Login, Wealth, Transfer) berjalan secara bersamaan** di port masing-masing (8001, 8002, dan 8003) agar aplikasi dapat berfungsi sepenuhnya dan saling berkomunikasi.
- Kunci `INTERNAL_SECRET_KEY` di dalam `.env` harus sama di ketiga layanan untuk keperluan autentikasi internal antar microservice.
