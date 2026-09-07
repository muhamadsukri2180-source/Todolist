# TaskFlow — Personal Productivity

Aplikasi web manajemen tugas dan produktivitas pribadi (*full-stack*) berbasis **Laravel** dan **Tailwind CSS**. Seluruh tampilan dan pesan aplikasi disajikan **100% dalam Bahasa Indonesia**.

---

## 🚀 Fitur Utama

- **Halaman Beranda (*Landing Page*)**: Desain modern dan responsif.
- **Autentikasi Pengguna**:
  - Pendaftaran akun baru (`/daftar`) menggunakan Nama, Email, dan Kata Sandi.
  - Masuk ke akun (`/masuk`) menggunakan **Username** dan Kata Sandi.
- **Akun Admin Bawaan (*Built-in*)**: Akun administrator sudah otomatis tersedia dari sistem tanpa perlu mendaftar manual.
- **Panel Admin (*Read-Only*)**: Halaman khusus admin (`/admin/pengguna`) untuk memantau data seluruh pengguna terdaftar (khusus melihat data, tanpa tombol edit/hapus).
- **Dasbor Tugas Pribadi (`/tugas`)**:
  - Isolasi data (setiap pengguna hanya mengelola tugas miliknya).
  - Pilihan tingkat prioritas visual bundaran: 🔵 Rendah, 🟡 Sedang, 🔴 Tinggi.
  - Tenggat waktu dan pengurutan waktu (**Waktu Terdekat** & **Waktu Terjauh**).
  - Pencarian instan dan penyaring status (*Semua*, *Belum Selesai*, *Selesai*).
  - Bilah persentase kemajuan penyelesaian tugas secara waktu nyata.
  - Paginasi 10 tugas per halaman dengan kotak putih bersih.

---

## 👥 Akun Bawaan untuk Pengujian

| Peran | Username | Kata Sandi | Akses |
|---|---|---|---|
| **Administrator** | `admin` | `password123` | Akses penuh: Tugas pribadi & Panel Admin (`/admin/pengguna`) |
| **Pengguna Biasa** | `sukri` | `password123` | Akses dasbor tugas pribadi (`/tugas`) |

---

## 🛠️ Prasyarat Sistem

- **PHP**: Versi 8.1 atau lebih baru
- **Composer**: Versi 2.0 atau lebih baru
- **Basis Data**: MySQL (Laragon / XAMPP) atau SQLite
- **Web Server**: Laragon / Apache / `php artisan serve`

---

## 💻 Cara Pemasangan & Menjalankan Aplikasi

Ikuti langkah-langkah ringkas berikut di terminal komputer Anda:

### 1. Masuk ke Folder Proyek
```bash
cd c:\laragon\www\Todolist
```

### 2. Pasang Dependensi
```bash
composer install
```

### 3. Konfigurasi Lingkungan (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
copy .env.example .env
```
Pastikan pengaturan database di file `.env` sudah sesuai (misal Laragon):
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todolist
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Kunci Aplikasi
```bash
php artisan key:generate
```

### 5. Buat Database & Jalankan Migrasi
Buat database baru bernama `todolist` di MySQL Anda, lalu jalankan:
```bash
php artisan migrate --seed
```

### 6. Jalankan Server
```bash
php artisan serve
```

Buka aplikasi di browser melalui: **`http://127.0.0.1:8000`** atau **`http://todolist.test`** (Laragon).

---

## 🧪 Pengujian Otomatis

Aplikasi telah dilengkapi pengujian otomatis lengkap menggunakan PHPUnit. Jalankan:

```bash
php artisan test
```

> **Hasil:** 27 pengujian lolos (100% Lulus, 83 asersi).

---

## 📧 Informasi Penyelesaian Proyek

- **Email Pemberitahuan**: `anggidputra567@gmail.com`
- **Status Proyek**: 100% Selesai & Berfungsi Penuh
- **Bahasa Antarmuka**: 100% Bahasa Indonesia
