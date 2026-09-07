# TaskFlow — Personal Productivity (Sistem Produktivitas Pribadi)

Aplikasi **TaskFlow — Personal Productivity** adalah aplikasi web manajemen produktivitas terpadu (*full-stack*) yang dibangun menggunakan kerangka kerja **Laravel** untuk backend dan **Blade + Tailwind CSS** untuk antarmuka pengguna (frontend), terintegrasi penuh dengan basis data **MySQL / MariaDB / SQLite**.

Seluruh teks antarmuka, notifikasi, pesan validasi formulir, dan navigasi disajikan **100% dalam Bahasa Indonesia**.

---

## 🚀 Fitur-Fitur Utama

### 1. 🌐 Halaman Beranda (Landing Page)
- Tampilan landing page modern dan responsif dengan tema profesional **TaskFlow — Personal Productivity**.
- Menampilkan nilai manfaat, rincian fitur utama, statistik visual, dan tautan langsung untuk mendaftar atau masuk ke akun.

### 2. 🔐 Sistem Autentikasi (Daftar & Masuk)
- **Halaman Pendaftaran Akun (`/daftar`)**:
  - Mendaftar dengan **Nama Lengkap**, **Username** (opsional/otomatis dibuatkan jika dikosongkan), **Alamat Email**, dan **Kata Sandi**.
- **Halaman Masuk (`/masuk`)**:
  - Otentikasi aman menggunakan **Username** dan **Kata Sandi**.
- **Keluar Sistem (`/keluar`)**:
  - Mengakhiri sesi pengguna dengan aman dan kembali ke halaman utama.

### 3. 🛡️ Panel Administrator Khusus Baca / Read-Only (`/admin/pengguna`)
- Hak akses dilindungi oleh middleware `admin` (pengguna biasa dilarang mengakses / 403 Forbidden).
- **Hanya Bisa Melihat (Read-Only)**:
  - Melihat seluruh daftar pengguna terdaftar lengkap dengan avatar inisial, nama, username, email, peran, total tugas yang dimiliki, dan tanggal bergabung.
  - Ringkasan statistik (Total Pengguna, Total Admin, Total Pengguna Biasa, dan Total Seluruh Tugas).
  - Fitur pencarian pengguna berdasarkan nama, username, atau email.
  - **Bebas dari manipulasi data**: Tidak tersedia tombol tambah, edit, atau hapus data pengguna untuk menjamin keamanan read-only.

### 4. 📝 Dasbor Tugas Pribadi (`/tugas`)
- **Isolasi Tugas**: Setiap pengguna hanya dapat melihat dan mengelola tugas miliknya sendiri.
- **Tambah Tugas Baru**:
  - Judul tugas dan rincian catatan/deskripsi (opsional).
  - **Tingkat Prioritas Visual** dengan pemilih bundaran:
    - 🔵 **Rendah**
    - 🟡 **Sedang** (bawaan)
    - 🔴 **Tinggi**
  - **Tenggat Waktu**: Pemilih tanggal dengan penanda tenggat waktu terlewat (merah), tenggat hari ini (kuning), dan mendatang (biru).
- **Pengurutan Berdasarkan Tenggat Waktu**:
  - ⏳ **Waktu Terdekat**: Menempatkan tugas dengan tenggat terdekat di posisi paling atas.
  - 📅 **Waktu Terjauh**: Menempatkan tugas dengan tenggat terjauh di posisi paling atas.
  - ⏱️ **Terbaru**: Menampilkan tugas berdasarkan urutan waktu penambahan terbaru.
- **Pencarian Cerdas**: Mencari tugas secara instan berdasarkan judul atau deskripsi.
- **Penyaring Status**: Tab penyaring **Semua**, **Belum Selesai**, dan **Selesai**.
- **Paginasi 10 Tugas Per Halaman**: Menampilkan maksimal 10 tugas per halaman dengan navigasi halaman bernomor.
- **Bilah Kemajuan Otomatis**: Menghitung persentase penyelesaian tugas (% Selesai) secara waktu nyata.
- **Ubah & Tandai Selesai**: Centang status tugas instan atau ubah rincian melalui jendela dialog interaktif.
- **Hapus Tugas**: Menghapus tugas dengan dialog konfirmasi.

---

## 👥 Akun Bawaan untuk Pengujian Langsung

Aplikasi telah dilengkapi seeder data akun awal:

| Peran | Username | Kata Sandi | Hak Akses |
|---|---|---|---|
| **Administrator** | `admin` | `password123` | Mengelola tugas pribadi & melihat seluruh pengguna di `/admin/pengguna` (Read-Only) |
| **Pengguna Biasa** | `sukri` | `password123` | Mengelola tugas pribadi di `/tugas` |

---

## 🛠️ Prasyarat Sistem

- **PHP**: Versi 8.1 atau yang lebih baru
- **Composer**: Versi 2.0 atau yang lebih baru
- **Basis Data**: MySQL (Laragon / XAMPP) atau SQLite
- **Web Server**: Laragon / Apache / Nginx / PHP Built-in Server

---

## 💻 Panduan Instalasi & Menjalankan Aplikasi

### 1. Masuk ke Direktori Proyek
Buka terminal PowerShell atau Command Prompt pada komputer Anda:
```bash
cd c:\laragon\www\Todolist
```

### 2. Pasang Dependensi Composer
```bash
composer install
```

### 3. Konfigurasi Lingkungan (`.env`)
Salin berkas contoh konfigurasi lingkungan:
```bash
copy .env.example .env
```

Sesuaikan baris konfigurasi basis data di dalam berkas `.env` (misal MySQL Laragon):
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

### 5. Jalankan Migrasi & Pengisian Data Awal (Seeder)
Jalankan migrasi tabel sekaligus mengisi akun awal pengujian:
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

### 6. Jalankan Server Aplikasi
Jalankan server pengembangan lokal:
```bash
php artisan serve
```

Aplikasi dapat langsung diakses melalui peramban:
- **Halaman Beranda**: `http://127.0.0.1:8000` atau `http://todolist.test`
- **Halaman Masuk**: `http://127.0.0.1:8000/masuk`
- **Halaman Daftar**: `http://127.0.0.1:8000/daftar`
- **Dasbor Tugas**: `http://127.0.0.1:8000/tugas`
- **Panel Admin**: `http://127.0.0.1:8000/admin/pengguna`

---

## 🧪 Pengujian Otomatis (Unit & Fitur)

Aplikasi telah divalidasi dengan rangkaian uji otomatis lengkap menggunakan PHPUnit:

```bash
php artisan test
```

**Hasil Pengujian:**
```text
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\AdminTest
  ✓ guest cannot access admin user list
  ✓ regular user is forbidden from admin user list
  ✓ admin can view registered users list
  ✓ admin can search registered users

   PASS  Tests\Feature\AuthTest
  ✓ guest can view registration page
  ✓ guest can register new account
  ✓ registration auto generates clean username if not provided
  ✓ registration fails with duplicate email
  ✓ guest can view login page
  ✓ user can login using username and password
  ✓ login fails with invalid credentials
  ✓ authenticated user can logout

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response

   PASS  Tests\Feature\TodoTest
  ✓ it displays the landing page at root
  ✓ guest cannot access todos page
  ✓ authenticated user can display todos page
  ✓ user can create a new todo with priority and due date
  ✓ user can search todos by keyword
  ✓ user can sort todos by deadline
  ✓ it paginates todos 10 per page
  ✓ user can mark todo as completed
  ✓ user can delete a todo
  ✓ it calculates correct progress percentage
  ✓ user cannot see or modify another users todo

  Tests:    25 passed (77 assertions)
```

---

## 📧 Informasi Penyelesaian Proyek

Proyek telah selesai dikembangkan, diuji, dan memenuhi seluruh kriteria yang diminta:
- **Surel / Email Pemberitahuan**: `anggidputra567@gmail.com`
- **Status Pengembangan**: 100% Selesai & Berfungsi Penuh
- **Bahasa Antarmuka**: 100% Bahasa Indonesia
- **Tema Proyek**: TaskFlow — Personal Productivity
