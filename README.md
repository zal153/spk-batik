# Sistem Pendukung Keputusan (SPK) Pemilihan Batik Terbaik - Toko Apollo

Aplikasi Sistem Pendukung Keputusan (SPK) untuk menentukan rekomendasi batik terbaik di Toko Apollo menggunakan metode **Analytical Hierarchy Process (AHP)**. Proyek ini dibangun menggunakan **Laravel 13**, **Tailwind CSS v4**, **AlpineJS**, dan **MySQL/MariaDB**.

---

## 🛠️ Prasyarat Sistem

Sebelum memulai, pastikan sistem Anda telah terpasang perangkat lunak berikut:
* **PHP >= 8.3**
* **Composer** (Dependency Manager untuk PHP)
* **Node.js** & **NPM** (untuk aset frontend)
* Database Server (**MySQL** atau **MariaDB**)
* Local Server (seperti **Laragon**, **XAMPP**, atau menggunakan `php artisan serve`)

---

## 🚀 Langkah-Langkah Instalasi & Setup Awal

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di komputer lokal Anda:

### 1. Salin / Unduh Repositori
Buka terminal Anda, lalu masuk ke direktori web server Anda (misal `C:\laragon\www\`):
```bash
cd c:\laragon\www\spk-batik
```

### 2. Salin Berkas Environment Config
Salin berkas konfigurasi `.env.example` menjadi `.env`:
* **Melalui terminal (Windows Command Prompt / PowerShell):**
  ```powershell
  copy .env.example .env
  ```
* **Melalui terminal (Git Bash / Linux):**
  ```bash
  cp .env.example .env
  ```

### 3. Konfigurasi Database di `.env`
Buka berkas `.env` yang baru dibuat dengan teks editor Anda, lalu sesuaikan konfigurasi koneksi database Anda (biasanya pada Laragon atau XAMPP default-nya seperti berikut):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_batik
DB_USERNAME=root
DB_PASSWORD=
```
*Catatan: Pastikan Anda telah membuat database kosong bernama `spk_batik` di phpMyAdmin, Laragon Database tool, atau MySQL CLI.*

### 4. Pasang Dependensi PHP (Composer)
Jalankan perintah berikut untuk mengunduh semua library PHP yang diperlukan proyek:
```bash
composer install
```

### 5. Pasang Dependensi Node (NPM)
Pasang semua paket pustaka JavaScript/CSS (termasuk Tailwind CSS, SweetAlert2, dll.):
```bash
npm install
```

### 6. Generate Application Key
Buat kunci enkripsi aplikasi Laravel baru:
```bash
php artisan key:generate
```

### 7. Jalankan Migrasi & Seeding Database
Jalankan migrasi tabel database sekaligus mengisi data kriteria, matriks AHP awal, serta 16 data batik alternatif (sesuai file Excel Toko Apollo):
```bash
php artisan migrate:fresh --seed
```

### 8. Jalankan Sistem & Aplikasi Web (Development Mode)
Untuk menjalankan seluruh layanan pengembangan lokal secara bersamaan (termasuk Laravel Server, Queue Listener, dan Vite development server), Anda cukup menjalankan satu perintah berikut:
```bash
composer run dev
```
Setelah itu, buka tautan aplikasi di browser Anda (biasanya `http://127.0.0.1:8000` atau `http://spk-batik.test` jika menggunakan Laragon).

*Catatan: Jika Anda ingin membangun aset frontend statis untuk produksi, Anda dapat menjalankan perintah `npm run build`.*

---

## 🔑 Akun Demo / Uji Coba

Tabel berikut berisi informasi akun uji coba yang siap digunakan setelah proses seeding:

| Peran (Role) | Email | Kata Sandi (Password) |
|---|---|---|---|
| **Admin** | `admin@batik.com` | `password` | 
| **Customer** | `customer@batik.com` | `password` |
