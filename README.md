# TaskFlow — Personal Productivity (Sistem Produktivitas Pribadi)

Aplikasi **TaskFlow — Personal Productivity** adalah platform manajemen tugas dan produktivitas terpadu (*full-stack web application*) yang dibangun dengan arsitektur modern menggunakan kerangka kerja **Laravel** pada sisi backend dan **Blade + Tailwind CSS** pada sisi antarmuka pengguna (frontend). 

Aplikasi dirancang responsif, intuitif, dan nyaman digunakan pada skala layar normal (zoom 100%). Seluruh teks antarmuka, notifikasi, validasi formulir, dan navigasi disajikan **100% dalam Bahasa Indonesia**.

---

## 📋 Daftar Isi

1. [Fitur-Fitur Utama](#-fitur-fitur-utama)
2. [Akun Bawaan Sistem](#-akun-bawaan-sistem-siap-pakai)
3. [Prasyarat Sistem](#-prasyarat-sistem)
4. [Panduan Langkah-demi-Langkah Instalasi](#-panduan-langkah-demi-langkah-instalasi)
   - [Metode 1: Menggunakan Laragon (Sangat Direkomendasikan)](#metode-1-menggunakan-laragon-direkomendasikan)
   - [Metode 2: Menggunakan XAMPP atau Terminal Standar](#metode-2-menggunakan-xampp-atau-terminal-standar)
5. [Daftar Rute Halaman Aplikasi](#-daftar-rute-halaman-aplikasi)
6. [Panduan Penggunaan Aplikasi](#-panduan-penggunaan-aplikasi)
7. [Solusi Masalah Umum (Troubleshooting)](#-solusi-masalah-umum-troubleshooting)
8. [Pengujian Otomatis (Automated Testing)](#-pengujian-otomatis-automated-testing)
9. [Struktur Berkas Proyek](#-struktur-berkas-proyek)
10. [Informasi Penyelesaian Proyek](#-informasi-penyelesaian-proyek)

---

## 🚀 Fitur-Fitur Utama

### 1. 🌐 Halaman Beranda (*Landing Page*) — `/`
- Tampilan landing page modern, bersih, dan responsif bertema **TaskFlow — Personal Productivity**.
- Memaparkan nilai manfaat, pratinjau fitur unggulan, dan tombol navigasi langsung menuju halaman Masuk atau Daftar.

### 2. 🔐 Sistem Autentikasi Mandiri
- **Pendaftaran Akun (`/daftar`)**:
  - Khusus untuk mendaftarkan akun pengguna baru.
  - Meminta **Nama Lengkap**, **Alamat Email**, dan **Kata Sandi** (serta *Username* opsional yang otomatis dibentuk jika dikosongkan).
  - Dilengkapi proteksi dan reservasi nama pengguna sehingga kata `admin` atau `administrator` tidak dapat didaftarkan kembali.
  - Tampilan berlatar belakang putih bersih dengan pola bintik-bintik halus minimalis (*sparse dot pattern*).
- **Akun Administrator Bawaan Controller (*Zero-Registration Admin*)**:
  - Akun Administrator sudah otomatis disediakan langsung dari dalam sistem (`AuthController`), sehingga **tidak perlu mendaftar secara manual**.
- **Masuk ke Akun (`/masuk`)**:
  - Masuk akun secara aman menggunakan **Username** dan **Kata Sandi**.
  - Dilengkapi fitur tombol mata untuk melihat/menyembunyikan kata sandi dan kotak informasi akun demo siap pakai.
- **Keluar Sistem (`/keluar`)**:
  - Mengakhiri sesi pengguna dengan aman dan kembali ke halaman utama disertai pesan konfirmasi.

### 3. 🛡️ Panel Administrator Khusus Baca / *Read-Only* — `/admin/pengguna`
- **Keamanan Berlapis**: Dilindungi oleh middleware khusus `admin`. Pengguna non-admin yang mencoba mengakses akan langsung ditolak (*403 Forbidden*).
- **Mode Baca Murni (*Read-Only*)**:
  - Menampilkan daftar tabel seluruh pengguna terdaftar (avatar inisial, nama, username, email, peran, total tugas yang dimiliki, dan tanggal bergabung).
  - Ringkasan metrik statistik (Total Pengguna, Total Admin, Pengguna Biasa, dan Total Seluruh Tugas).
  - Kolom pencarian data pengguna instan berdasarkan nama, username, atau email.
  - **Bebas manipulasi data**: Sama sekali tidak tersedia tombol aksi untuk menambah, mengedit, atau menghapus data pengguna guna menjaga integritas *read-only*.

### 4. 📝 Dasbor Tugas Pribadi — `/tugas`
- **Isolasi Tugas Pengguna**: Setiap pengguna hanya dapat melihat dan mengelola tugas miliknya sendiri secara privat.
- **Tambah Tugas Baru**:
  - Judul tugas, catatan/deskripsi tambahan, dan pemilih tanggal tenggat waktu.
  - **Tingkat Prioritas Bundaran Visual**: Pilihan prioritas 🔵 **Rendah**, 🟡 **Sedang** (bawaan), dan 🔴 **Tinggi** dengan pemilih bundaran yang mudah dibedakan.
- **Pengurutan Berdasarkan Tenggat Waktu**:
  - ⏳ **Waktu Terdekat**: Menempatkan tugas dengan tenggat waktu paling mendesak di posisi teratas.
  - 📅 **Waktu Terjauh**: Menempatkan tugas dengan batas waktu terjauh di posisi teratas.
  - ⏱️ **Terbaru**: Menampilkan tugas berdasarkan urutan penambahan paling baru.
- **Pencarian Cerdas & Filter Status**:
  - Kolom pencarian instan berdasarkan judul atau deskripsi tugas.
  - Tab penyaring status: **Semua**, **Belum Selesai (Menunggu)**, dan **Selesai**.
- **Bilah Kemajuan Real-Time (*Progress Bar*)**:
  - Menghitung persentase kemajuan tugas selesai secara otomatis (% Selesai) dengan bilah visual yang tebal dan jelas.
- **Paginasi Otomatis (10 Tugas Per Halaman)**:
  - Daftar tugas dibatasi rapi 10 tugas per halaman dengan tombol nomor halaman (*Sebelumnya* / *Berikutnya*).
  - Keterangan *"Menampilkan X sampai Y dari Z tugas"* disajikan dalam **kotak putih bersih (*pure white elevated box*)**.
- **Ubah & Hapus Tugas**:
  - Tombol centang cepat ubah status tugas (dengan efek coret teks selesai).
  - Modal dialog interaktif untuk mengubah rincian tugas.
  - Hapus tugas permanen dengan konfirmasi keamanan.

---

## 👥 Akun Bawaan Sistem (Siap Pakai)

Sistem telah menyediakan akun bawaan yang siap langsung digunakan tanpa perlu melakukan pendaftaran:

| Peran (*Role*) | Username | Kata Sandi | Hak Akses Utama |
|---|---|---|---|
| **Administrator** | `admin` | `password123` | Mengelola tugas pribadi & mengakses Panel Admin di `/admin/pengguna` (Read-Only) |
| **Pengguna Biasa** | `sukri` | `password123` | Mengelola tugas pribadi di dasbor `/tugas` |

> [!NOTE]
> Akun `admin` otomatis diinisialisasi oleh sistem (`AuthController`) bahkan jika basis data baru dibuat.

---

## 🛠️ Prasyarat Sistem

Sebelum memasang aplikasi, pastikan komputer Anda telah terpasang:
- **PHP**: Versi 8.1, 8.2, atau 8.3 (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`)
- **Composer**: Versi 2.0 atau yang lebih baru
- **Basis Data**: MySQL (versi 5.7+ / 8.0+) atau MariaDB (versi 10.3+)
- **Lingkungan Lokal**: Laragon (sangat disarankan di Windows) atau XAMPP

---

## 💻 Panduan Langkah-demi-Langkah Instalasi

### Metode 1: Menggunakan Laragon (Direkomendasikan)

Jika Anda menggunakan Laragon di Windows, ikuti langkah mudah berikut:

#### 1. Buka Direktori Proyek
Buka terminal PowerShell atau Command Prompt, lalu masuk ke folder proyek:
```bash
cd c:\laragon\www\Todolist
```

#### 2. Pasang Pustaka Dependensi Composer
Jalankan perintah berikut untuk mengunduh semua pustaka PHP yang diperlukan:
```bash
composer install
```

#### 3. Nyalakan Layanan Laragon
- Buka aplikasi **Laragon**.
- Klik tombol **Start All** (memastikan Apache dan MySQL berstatus running / hijau).

#### 4. Buat Basis Data MySQL
Buat sebuah basis data baru bernama `todolist` melalui salah satu cara:
- Melalui HeidiSQL / phpMyAdmin di Laragon: buat database baru dengan nama `todolist`.
- Atau jalankan perintah SQL di terminal:
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS todolist;"
```

#### 5. Konfigurasi Lingkungan (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
copy .env.example .env
```

Buka file `.env` dan pastikan konfigurasi basis data sesuai dengan pengaturan MySQL Laragon:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todolist
DB_USERNAME=root
DB_PASSWORD=
```

#### 6. Buat Kunci Aplikasi (*Application Key*)
Jalankan perintah pembuatan kunci enkripsi Laravel:
```bash
php artisan key:generate
```

#### 7. Jalankan Migrasi & Seeder Data Awal
Eksekusi migrasi untuk membuat seluruh tabel dan menyuntikkan data awal:
```bash
php artisan migrate --seed
```
*(Atau jika ingin menjalankan seeder admin secara khusus: `php artisan db:seed --class=AdminSeeder`)*.

#### 8. Buka Aplikasi di Browser
Aplikasi siap dibuka melalui peramban:
- Melalui virtual host Laragon: **`http://todolist.test`**
- Atau jalankan server bawaan Laravel:
```bash
php artisan serve
```
Lalu buka alamat: **`http://127.0.0.1:8000`**

---

### Metode 2: Menggunakan XAMPP atau Terminal Standar

#### 1. Posisikan Proyek di Folder Server Web
- Jika menggunakan XAMPP: letakkan di `C:\xampp\htdocs\Todolist`.
- Buka XAMPP Control Panel dan nyalakan **Apache** serta **MySQL**.

#### 2. Buat Basis Data via phpMyAdmin
- Buka `http://localhost/phpmyadmin` di browser.
- Klik menu **New** / **Baru**, beri nama basis data `todolist`, lalu klik **Create**.

#### 3. Setup Konfigurasi & Jalankan Migrasi
Buka terminal di dalam folder proyek, lalu jalankan rentetan perintah:
```bash
# 1. Pasang dependensi
composer install

# 2. Buat file .env jika belum ada
copy .env.example .env

# 3. Generate key aplikasi
php artisan key:generate

# 4. Jalankan migrasi tabel & seeder
php artisan migrate --seed

# 5. Jalankan server aplikasi
php artisan serve
```

Aplikasi dapat langsung diakses melalui alamat: **`http://127.0.0.1:8000`**.

---

## 🗺️ Daftar Rute Halaman Aplikasi

Berikut adalah peta rute web aplikasi TaskFlow:

| Rute Web | Metode HTTP | Hak Akses | Keterangan Halaman |
|---|---|---|---|
| `/` | `GET` | Publik (Semua) | Halaman Utama (*Landing Page*) |
| `/daftar` | `GET` / `POST` | Tamu (*Guest*) | Formulir pendaftaran akun pengguna baru |
| `/masuk` | `GET` / `POST` | Tamu (*Guest*) | Formulir masuk menggunakan username & kata sandi |
| `/keluar` | `POST` | Terotentikasi (*Auth*) | Mengakhiri sesi masuk pengguna |
| `/tugas` | `GET` / `POST` | Pengguna / Admin | Dasbor pengelolaan tugas pribadi |
| `/tugas/{todo}` | `PATCH` / `DELETE` | Pemilik Tugas / Admin | Memperbarui atau menghapus tugas |
| `/admin/pengguna` | `GET` | **Khusus Administrator** | Panel pantau data pengguna terdaftar (*Read-Only*) |

---

## 📖 Panduan Penggunaan Aplikasi

### 1. Masuk Sebagai Administrator
1. Buka halaman `/masuk`.
2. Masukkan Username: `admin` dan Kata Sandi: `password123`.
3. Setelah masuk, klik tombol **Panel Admin** di bilah atas untuk melihat daftar seluruh pengguna terdaftar beserta statistik sistem.
4. Anda juga dapat mengelola tugas pribadi admin di halaman `/tugas`.

### 2. Mendaftar Akun Pengguna Baru
1. Buka halaman `/daftar`.
2. Isi Nama Lengkap, Username pilihan Anda (atau biarkan kosong untuk dibuatkan otomatis), Alamat Email, dan Kata Sandi (minimal 6 karakter).
3. Klik tombol **Daftar Sekarang**. Anda akan langsung dialihkan ke dasbor tugas pribadi Anda.

### 3. Mengelola Tugas di Dasbor
1. **Tambah Tugas**:
   - Tulis judul tugas (wajib).
   - Tentukan tenggat waktu (opsional).
   - Pilih bundaran prioritas: 🔵 Rendah, 🟡 Sedang, atau 🔴 Tinggi.
   - Tambahkan catatan/deskripsi jika diperlukan, lalu klik **Simpan Tugas**.
2. **Saring & Urutkan Tugas**:
   - Gunakan tab status (*Semua*, *Belum Selesai*, *Selesai*) untuk memfilter tugas.
   - Klik tombol pengurutan waktu (*Waktu Terdekat*, *Waktu Terjauh*, *Terbaru*) untuk menyusun daftar sesuai urgensi.
3. **Pencarian**:
   - Ketikkan kata kunci pada kolom pencarian untuk menemukan tugas secara instan.
4. **Tandai Selesai**:
   - Klik kotak centang di samping judul tugas untuk mengubah status menjadi selesai.
   - Bilah persentase kemajuan akan otomatis bertambah secara langsung.
5. **Navigasi Halaman**:
   - Jika tugas melebihi 10 item, gunakan navigasi nomor halaman di bagian bawah untuk berpindah halaman.

---

## 🔧 Solusi Masalah Umum (*Troubleshooting*)

### 1. Pesan Kesalahan: `Access denied for user 'root'@'localhost'`
- **Penyebab**: Konfigurasi username atau password MySQL pada file `.env` tidak cocok dengan server lokal Anda.
- **Solusi**: Buka file `.env`, ubah `DB_USERNAME` dan `DB_PASSWORD` sesuai konfigurasi MySQL lokal Anda (pada Laragon bawaan: `DB_USERNAME=root` dan `DB_PASSWORD=` kosong).

### 2. Pesan Kesalahan: `Unknown database 'todolist'`
- **Penyebab**: Basis data `todolist` belum dibuat di MySQL.
- **Solusi**: Buat basis data terlebih dahulu dengan perintah:
  ```bash
  mysql -u root -e "CREATE DATABASE todolist;"
  ```
  Lalu jalankan kembali `php artisan migrate --seed`.

### 3. Pesan Kesalahan: `No application encryption key has been specified`
- **Solusi**: Jalankan perintah pembuatan kunci aplikasi:
  ```bash
  php artisan key:generate
  ```

### 4. Ingin Mengulang / Mereset Seluruh Data dari Awal?
Jalankan perintah *fresh migration* berikut untuk mereset seluruh tabel dan mengisi ulang data bawaan:
```bash
php artisan migrate:fresh --seed
```

---

## 🧪 Pengujian Otomatis (*Automated Testing*)

Proyek ini telah dilengkapi dengan pengujian fitur dan unit komprehensif menggunakan **PHPUnit**:

Untuk menjalankan pengujian otomatis:
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
  ✓ default admin account is automatically ensured by controller
  ✓ user cannot register with admin username
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

  Tests:    27 passed (83 assertions)
  Duration: 2.22s
```

---

## 📂 Struktur Berkas Proyek

Berikut adalah ringkasan berkas-berkas penting pada aplikasi TaskFlow:

```text
Todolist/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php   # Mengelola panel admin read-only pengguna
│   │   │   ├── AuthController.php    # Mengelola pendaftaran, login username, & logout
│   │   │   └── TodoController.php    # Mengelola CRUD tugas & isolasi data pengguna
│   │   └── Middleware/
│   │       └── AdminMiddleware.php   # Membatasi akses khusus pengguna role admin
│   └── Models/
│       ├── Todo.php                  # Model data tugas & relasi ke user
│       └── User.php                  # Model data pengguna & helper isAdmin()
├── database/
│   ├── migrations/                   # Skema tabel users (username, role) & todos (user_id)
│   └── seeders/
│       └── AdminSeeder.php           # Seeder akun admin & pengguna awal
├── resources/
│   └── views/
│       ├── admin/
│       │   └── users.blade.php       # Halaman tabel pantau pengguna read-only
│       ├── auth/
│       │   ├── login.blade.php       # Halaman masuk (username & sandi)
│       │   └── register.blade.php    # Halaman daftar akun pengguna baru
│       ├── todos/
│       │   └── index.blade.php       # Dasbor tugas pribadi (prioritas, tenggat, filter)
│       ├── vendor/
│       │   └── pagination/
│       │       └── tailwind.blade.php # Tampilan paginasi kotak putih Bahasa Indonesia
│       └── landing.blade.php         # Halaman beranda utama (Landing Page)
├── routes/
│   └── web.php                       # Definisi seluruh rute aplikasi
└── tests/
    └── Feature/
        ├── AdminTest.php             # Uji coba keamanan & read-only panel admin
        ├── AuthTest.php              # Uji coba pendaftaran & login username
        └── TodoTest.php              # Uji coba fungsionalitas pengelolaan tugas
```

---

## 📧 Informasi Penyelesaian Proyek

Proyek ini telah dikembangkan dan diselesaikan secara menyeluruh sesuai dengan seluruh spesifikasi yang diminta:
- **Surel / Email Tujuan**: `anggidputra567@gmail.com`
- **Status Proyek**: 100% Selesai & Berfungsi Penuh
- **Bahasa**: Murni Bahasa Indonesia
- **Tema Proyek**: TaskFlow — Personal Productivity
