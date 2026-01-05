# SIMPKH (Sistem Informasi Manajemen Pemetaan Kawasan Hutan)

## Langkah Instalasi

Untuk menjalankan proyek ini (setelah clone atau copy), pastikan sudah terinstall:
- **PHP**
- **Composer**
- **Node.js**
- **Database Server** (MySQL/MariaDB, bisa via XAMPP/Laragon)

Ikuti langkah-langkah berikut di terminal (PowerShell/CMD) di dalam folder project:

### 1. Install Library PHP (Composer)
Unduh dependensi PHP yang dibutuhkan.
```powershell
composer install
```

### 2. Install Library JavaScript (NPM)
Unduh dependensi Frontend.
```powershell
npm install
```

### 3. Setup Environment (.env)
Duplikasi file konfigurasi contoh, lalu sesuaikan dengan database lokal Anda.
```powershell
copy .env.example .env
```
> **Penting:** Buka file `.env` dan atur `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan settingan database di laptop Anda (Misal: Buat database kosong bernama `simpkh` di phpMyAdmin).

### 4. Generate Application Key
Buat key enkripsi aplikasi baru.
```powershell
php artisan key:generate
```

### 5. Migrasi Database & Seeding
Buat tabel-tabel dan isi data awal (User Admin, dll).
```powershell
php artisan migrate --seed
```
*Catatan: Gunakan `--seed` agar data awal dibuatkan otomatis.*

### 6. Jalankan Aplikasi
Jalankan dua terminal secara bersamaan:

**Terminal 1 (Backend Server):**
```powershell
php artisan serve
```

**Terminal 2 (Frontend Build/Watch):**
```powershell
npm run dev
```

Akses aplikasi di browser melalui URL yang muncul (biasanya [http://127.0.0.1:8000](http://127.0.0.1:8000)).
