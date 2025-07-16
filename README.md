<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="280" alt="Laravel Logo">
</p>

<h2 align="center">Aplikasi Manajemen Penjualan - PT. Niaga Mandiri</h2>

<p align="center">
  Sistem berbasis web untuk manajemen data Produk, Kategori, dan Penjualan di perusahaan PT. Niaga Mandiri.<br>
  Dibangun dengan Laravel 12 dan UI modern berbasis Volt Admin Bootstrap 5.
</p>

---

## 📋 Daftar Isi

-   [🧾 Tentang Proyek](#-tentang-proyek)
-   [📦 Teknologi Digunakan](#-teknologi-digunakan)
-   [⚙️ Requirement Sistem](#️-requirement-sistem)
-   [🚀 Instalasi](#-instalasi)

---

## 🧾 Tentang Proyek

Aplikasi ini digunakan untuk mengelola:

-   Data Produk dan Kategori
-   Pencatatan dan manajemen Penjualan
-   Statistik visual berbentuk grafik (Chart.js)
-   Pencarian berdasarkan nama produk dan tanggal

Proyek ini menggunakan pendekatan MVC Laravel, dan dirancang agar mudah dikembangkan lebih lanjut.

---

## 📦 Teknologi Digunakan

| Teknologi                         | Versi / Tools |
| --------------------------------- | ------------- |
| Laravel                           | 12.x          |
| PHP                               | >= 8.2        |
| Composer                          | >= 2.x        |
| Blade Templating                  | ✅            |
| Chart.js                          | ✅            |
| Volt Admin Template (Bootstrap 5) | ✅            |

---

## ⚙️ Requirement Sistem

Pastikan environment kamu memenuhi:

-   PHP >= 8.2
-   Composer >= 2.0
-   Ekstensi PHP yang dibutuhkan:
    -   `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`

---

## 🚀 Instalasi

```bash
# 1. Clone Repository
git clone https://github.com/fauzanryz/niagamandiri-app.git
cd niagamandiri-app

# 2. Install Dependensi
composer install

# 3. Konfigurasi Environment
cp .env.example .env
php artisan key:generate

# 4. Setup Database (jika menggunakan database)
# Edit konfigurasi DB di file .env sesuai kebutuhan

# 5. Jalankan Aplikasi
php artisan serve
```
