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

## 💻 Panduan Lengkap Pemasangan & Menjalankan Aplikasi

Ikuti panduan langkah demi langkah di bawah ini untuk memasang dan menjalankan aplikasi di komputer lokal Anda:

### Langkah 1: Buka Terminal dan Masuk ke Direktori Proyek
Buka Command Prompt (CMD), PowerShell, atau terminal Laragon, lalu jalankan:
```bash
cd c:\laragon\www\Todolist
```

---

### Langkah 2: Pasang Paket Dependensi PHP (Composer)
Unduh dan pasang pustaka yang dibutuhkan Laravel dengan perintah:
```bash
composer install
```
*(Tunggu hingga proses pengunduhan dependensi selesai).*

---

### Langkah 3: Siapkan File Konfigurasi Lingkungan (`.env`)
1. Gandakan file `.env.example` menjadi `.env`:
   - **Windows (CMD/PowerShell)**:
     ```bash
     copy .env.example .env
     ```
   - **Git Bash / Linux**:
     ```bash
     cp .env.example .env
     ```
2. Buka file `.env` di text editor (seperti VS Code atau Notepad), lalu pastikan pengaturan basis data (database) sesuai dengan server lokal Anda (Laragon / XAMPP):
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todolist
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   > **Catatan:** Secara default di Laragon atau XAMPP, `DB_USERNAME` adalah `root` dan `DB_PASSWORD` dikosongkan.

---

### Langkah 4: Buat Kunci Enkripsi Aplikasi (*App Key*)
Jalankan perintah ini untuk membuat *Application Encryption Key*:
```bash
php artisan key:generate
```

---

### Langkah 5: Buat Basis Data (Database) & Jalankan Migrasi
1. Pastikan layanan **MySQL** di Laragon / XAMPP sudah berjalan (**Start All**).
2. Buat database baru dengan nama `todolist`:
   - Lewat **phpMyAdmin** / **HeidiSQL**: Buat database baru bernama `todolist`.
   - Atau lewat baris perintah MySQL:
     ```sql
     CREATE DATABASE todolist;
     ```
3. Jalankan migrasi tabel dan data awal (seeder) ke dalam database:
   ```bash
   php artisan migrate --seed
   ```
   *(Perintah ini akan membuat seluruh struktur tabel dan menyiapkan data awal pengguna).*

---

### Langkah 6: Jalankan Server Aplikasi
Pilih salah satu metode untuk mengakses aplikasi:

- **Opsi A (Menggunakan Web Server Internal Laravel)**:
  Jalankan perintah:
  ```bash
  php artisan serve
  ```
  Kemudian buka peramban (*browser*) dan akses tautan:
  👉 **`http://127.0.0.1:8000`**

- **Opsi B (Menggunakan Laragon)**:
  Jika menggunakan Laragon dengan fitur Virtual Host aktif:
  Cukup klik **Start All** pada Laragon, lalu akses:
  👉 **`http://todolist.test`**

---

### Langkah 7: Masuk ke Akun Aplikasi
Setelah halaman web terbuka, klik menu **Masuk** di pojok kanan atas:
- **Admin**: Username `admin` | Kata Sandi `password123`
- **Pengguna**: Username `sukri` | Kata Sandi `password123` *(atau klik **Daftar** untuk membuat akun baru)*

---

## 📖 Alur Penggunaan Aplikasi

Berikut adalah alur panduan pengoperasian aplikasi baik untuk **Pengguna Biasa** maupun **Administrator**:

### 1. 👤 Alur Pengguna Biasa (Manajemen Tugas Pribadi)

1. **Pendaftaran Akun Baru**:
   - Buka halaman utama dan klik tombol **Daftar** di pojok kanan atas.
   - Masukkan **Nama Lengkap**, **Alamat Email**, dan **Kata Sandi**.
   - Sistem akan otomatis membuat akun dan mengarahkan langsung ke halaman masuk.
2. **Masuk ke Sistem**:
   - Masukkan **Username** dan **Kata Sandi** pada halaman `/masuk`.
3. **Mengelola Tugas Pribadi (`/tugas`)**:
   - **Menambah Tugas**: Isi judul tugas, deskripsi (opsional), tentukan tenggat waktu, dan pilih prioritas (🔵 Rendah, 🟡 Sedang, atau 🔴 Tinggi), lalu klik **Tambah Tugas**.
   - **Menandai Selesai**: Centang kotak status pada tugas yang telah diselesaikan. Bilah persentase kemajuan (*progress bar*) di bagian atas akan bertambah secara otomatis.
   - **Penyaringan & Pencarian**:
     - Gunakan kolom cari untuk menemukan tugas berdasarkan kata kunci judul.
     - Pilih filter status (**Semua**, **Belum Selesai**, atau **Selesai**).
     - Atur urutan deadline (**Waktu Terdekat** atau **Waktu Terjauh**).
   - **Edit & Hapus**: Klik tombol ikon pensil untuk mengubah tugas atau ikon tempat sampah untuk menghapusnya.
   - **Navigasi Halaman**: Jika tugas lebih dari 10, gunakan tombol paginasi di bawah untuk berpindah halaman.
4. **Keluar Akun**:
   - Klik tombol **Keluar** di navbar atas kapan saja untuk mengakhiri sesi.

---

### 2. 🛡️ Alur Administrator (Pemantauan Sistem)

1. **Masuk Sebagai Admin**:
   - Tidak perlu registrasi manual. Masuk melalui halaman `/masuk` menggunakan:
     - **Username**: `admin`
     - **Kata Sandi**: `password123`
2. **Navigasi ke Panel Admin**:
   - Di navbar atas admin akan muncul menu khusus **Data Pengguna**.
   - Klik menu tersebut untuk menuju ke halaman Panel Admin (`/admin/pengguna`).
3. **Memantau Pengguna Terdaftar (*Read-Only*)**:
   - **Statistik Sistem**: Admin dapat melihat ringkasan total pengguna terdaftar, total tugas dalam sistem, dan tingkat penyelesaian tugas.
   - **Daftar Pengguna**: Melihat data seluruh pengguna terdaftar mencakup nama, username, email, tanggal bergabung, serta jumlah tugas yang dimiliki masing-masing pengguna.
   - **Pencarian Data**: Gunakan kolom pencarian untuk menyaring pengguna berdasarkan nama, username, atau email.
   - *Catatan Keamanan*: Panel admin bersifat murni **Read-Only** (hanya pemantauan), tidak terdapat tombol ubah/hapus data pengguna guna menjaga integritas data.
4. **Mengelola Tugas Pribadi Admin**:
   - Admin juga dapat mengklik menu **Tugas Saya** untuk membuat dan mengelola daftar tugas pribadinya sendiri secara terpisah.

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
