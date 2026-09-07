# Aplikasi TODO List (Mini Application)

Aplikasi **TODO List** (Full-Stack Web Application) dibangun menggunakan framework **Laravel** untuk backend dan **Blade + Tailwind CSS** untuk frontend, terintegrasi penuh dengan database **MySQL / SQLite**.

---

## 🚀 Fitur Utama

1. **Tambah Todo Baru (Create)**:
   - Input judul tugas dan deskripsi opsional.
   - Pilihan **Tingkat Prioritas** dengan tombol bundaran visual:
     - 🔵 **Rendah (Low)**
     - 🟡 **Sedang (Medium)**
     - 🔴 **Tinggi (High)**
   - Input **Deadline / Tenggat Waktu** tugas (`due_date`).

2. **Manajemen Status & Filter (Read & Filter)**:
   - Tab filter status: **Semua**, **Belum Selesai (Pending)**, dan **Selesai (Completed)**.
   - Indikator badge tanggal tenggat: *Terlewat* (merah), *Deadline Hari Ini* (amber), dan *Mendatang* (indigo).

3. **Pencarian Real-Time (Search)**:
   - Bar pencarian tugas berdasarkan judul dan deskripsi.
   - Dapat dikombinasikan secara langsung dengan tab filter status.

4. **Progress Bar Penyelesaian**:
   - Indicator bar visual persentase penyelesaian tugas (% Selesai) secara real-time.

5. **Update & Edit Todo (Update)**:
   - Tombol toggle cepat untuk mengubah status selesai/belum selesai dengan efek strikethrough.
   - Modal dialog edit untuk memperbarui judul, deskripsi, prioritas, deadline, dan status.

6. **Hapus Todo (Delete)**:
   - Hapus tugas dari database secara permanen dengan dialog konfirmasi.

---

## 🛠️ Prasyarat Sistem

- **PHP**: `>= 8.1`
- **Composer**: `>= 2.0`
- **Database**: MySQL (Laragon / XAMPP) atau SQLite
- **Web Server**: Laragon / Apache / Nginx / Artisan Serve

---

## 💻 Langkah-Langkah Setup & Menjalankan Project

### 1. Ekstrak / Clone Repository
Buka terminal / PowerShell di direktori project:
```bash
cd c:\laragon\www\Todolist
```

### 2. Install Dependensi PHP
Jalankan Composer install untuk mengunduh seluruh vendor dependensi Laravel:
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` ke `.env` (jika belum ada):
```bash
cp .env.example .env
```

Pastikan konfigurasi database pada `.env` sudah sesuai dengan environment Anda (misalnya MySQL Laragon):
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todolist
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
Jalankan perintah generate key Laravel:
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi Database
Buat tabel `todos` beserta kolom prioritas & due date ke dalam database:
```bash
php artisan migrate
```

### 6. Menjalankan Server Aplikasi
Jalankan development server Laravel:
```bash
php artisan serve
```

Akses aplikasi melalui browser di:
`http://127.0.0.1:8000` atau `http://todolist.test` (jika menggunakan Laragon).

---

## 🧪 Pengujian Otomatis (Testing)

Proyek ini dilengkapi dengan Automated Feature Tests menggunakan PHPUnit. Untuk menjalankan seluruh pengujian:

```bash
php artisan test
```

**Hasil Pengujian:**
```text
   PASS  Tests\Feature\TodoTest
  ✓ it can display the todo list page
  ✓ user can create a new todo with priority and due date
  ✓ user can search todos by keyword
  ✓ user can mark todo as completed
  ✓ user can delete a todo
  ✓ it calculates correct progress percentage

  Tests:    6 passed (13 assertions)
```

---

## 📧 Informasi Penyelesaian Project

Project ini telah selesai dikembangkan dan diverifikasi sepenuhnya.
- **Penerima Notifikasi Email**: `anggidputra567@gmail.com`
- **Status Project**: Complete & Ready for Production/Deployment
