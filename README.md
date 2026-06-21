# 🍽️ Go.Canteen

**Go.Canteen** adalah sebuah sistem informasi berbasis web yang dirancang untuk mendigitalisasi dan mempermudah proses pemesanan makanan di kantin kampus. Sistem ini hadir dengan antarmuka yang bersih dan modern, serta dilengkapi algoritma validasi cerdas untuk mencegah bentrok stok dan bentrok penggunaan meja secara bersamaan.

---

## ✨ Fitur Unggulan

Sistem ini memiliki manajemen Hak Akses (Multi-Role) yang komprehensif, dibagi menjadi 3 peran pengguna:

### 🎓 1. Panel Mahasiswa (Pengguna)

* **Pemilihan Stand & Menu Real-Time** — Mahasiswa dapat menelusuri stand kantin beserta menu yang tersedia lengkap dengan stok dan rating.
* **Pemesanan Anti-Bentrok Meja** — Saat memilih tipe Dine In, sistem hanya menampilkan meja yang benar-benar kosong. Validasi di backend mencegah dua mahasiswa memesan meja yang sama secara bersamaan.
* **Validasi Stok Otomatis** — Sistem menggunakan row-locking pada transaksi database untuk mencegah dua pesanan menghabiskan stok yang sama secara bersamaan (race condition).
* **Pembayaran Cash & QRIS** — Mahasiswa dapat memilih metode pembayaran tunai di kasir, atau scan QRIS langsung dari sistem.
* **Riwayat & Status Pesanan Real-Time** — Memantau status pesanan secara transparan (Pending, Diproses, Siap, Selesai) dengan auto-refresh.
* **Rating & Ulasan Menu** — Memberi bintang dan komentar pada menu setelah pesanan selesai, yang dapat dilihat mahasiswa lain sebelum memesan.

### 🧑‍🍳 2. Panel Penjual

* Memiliki dasbor khusus untuk setiap pemilik stand, terisolasi dari data stand lain.
* **Kelola Menu (CRUD)** — Menambah, mengedit, dan menghapus menu beserta emoji dan kategori, khusus untuk stand miliknya sendiri.
* **Kelola Stok Cepat** — Kontrol stok dengan tombol pintas (+1, +5, −1, −5) tanpa perlu mengetik manual.
* **Manajemen Pesanan Masuk** — Meninjau dan mengubah status setiap pesanan yang masuk ke standnya (Pending → Diproses → Siap → Selesai).
* **Laporan Penjualan Mandiri** — Grafik pendapatan, menu terlaris, dan ulasan terbaru khusus stand miliknya.

### 👨‍💼 3. Panel Administrator

* **Kelola Data Stand (CRUD)** — Menambah, mengedit, dan menghapus stand kantin beserta emoji dan deskripsinya.
* **Manajemen Akun Penjual** — Membuat dan menghubungkan akun penjual ke stand tertentu.
* **Manajemen Meja** — Menambah, mengunci/membebaskan, dan menghapus data meja secara fleksibel.
* **Kelola Data Mahasiswa** — Mendaftarkan dan mengelola akun mahasiswa yang berhak memesan.
* **Laporan Penjualan Menyeluruh** — Grafik pendapatan seluruh kantin, filter per periode dan per stand, beserta menu terlaris.

---

## 💻 Tech Stack

Aplikasi ini dibangun menggunakan berbagai teknologi modern dan fungsional, antara lain:

**Frontend:**
* HTML5 & CSS3
* [Tailwind CSS](https://tailwindcss.com/) (Framework untuk styling antarmuka, via CDN)
* Vanilla JavaScript (Untuk manipulasi DOM dan interaksi keranjang/modal)
* [Chart.js](https://www.chartjs.org/) (Untuk visualisasi grafik laporan penjualan)

**Backend & Database:**
* [Laravel 10](https://laravel.com/) (PHP Framework)
* MySQL / MariaDB
* [Laragon](https://laragon.org/) (Local Development Environment)
* Eloquent ORM dengan Database Transaction & Row Locking (untuk mencegah race condition stok)

---

## 🚀 Panduan Instalasi (Local Development)

Jika Anda ingin menjalankan project ini di komputer lokal, pastikan Anda sudah menginstal [Composer](https://getcomposer.org/) dan [Laragon](https://laragon.org/).

### 1. Clone Repository

Buka terminal, lalu jalankan perintah ini:

```bash
git clone https://github.com/USERNAME/gocanteen-laravel.git
cd gocanteen-laravel
```

### 2. Install Package PHP yang Dibutuhkan

```bash
composer install
```

### 3. Jalankan Laragon

Buka aplikasi Laragon dan klik **Start All** (pastikan Apache dan MySQL berjalan).

### 4. Buat Database

Buka Database Manager (seperti HeidiSQL bawaan Laragon atau phpMyAdmin) dan buat database baru, misalnya dengan nama `gocanteen`.

### 5. Konfigurasi Environment

Copy file `.env.example` dan ubah namanya menjadi `.env`.

Buka file `.env` dan sesuaikan koneksi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gocanteen
DB_USERNAME=root
DB_PASSWORD=
```

Generate application key:

```bash
php artisan key:generate
```

### 6. Migrasi Database

Buat struktur tabel ke dalam database Anda:

```bash
php artisan migrate
```

### 7. (Opsional) Isi Data Awal

Jalankan seeder untuk mengisi data contoh (stand, kategori, menu, meja):

```bash
php artisan db:seed
```

Buat akun admin pertama lewat Tinker:

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@gocanteen.com',
    'password' => bcrypt('password123'),
    'role' => 'admin'
]);
```

### 8. Jalankan Aplikasi

Jika menggunakan Laragon, aplikasi otomatis dapat diakses tanpa server tambahan:

```
http://gocanteen-laravel.test
```

Atau jika ingin menjalankan server bawaan Laravel secara manual:

```bash
php artisan serve
```

Lalu buka:

```
http://127.0.0.1:8000
```

> **Catatan:** Proyek ini menggunakan Tailwind CSS melalui CDN, sehingga **tidak diperlukan** `npm install` atau proses build tambahan untuk styling.

---

## 📁 Struktur Proyek

```
gocanteen-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller khusus panel admin
│   │   ├── Penjual/        # Controller khusus panel penjual
│   │   ├── AuthController.php
│   │   ├── StandController.php
│   │   ├── MenuMhsController.php
│   │   ├── PesananController.php
│   │   └── ReviewController.php
│   └── Models/              # Eloquent Models (Stand, Menu, Pesanan, Meja, Review, dll)
├── database/
│   ├── migrations/          # Skema tabel database
│   └── seeders/             # Data contoh awal
├── resources/views/
│   ├── admin/                # Tampilan panel admin
│   ├── penjual/               # Tampilan panel penjual
│   ├── mahasiswa/             # Tampilan panel mahasiswa
│   └── auth/                   # Halaman login
└── routes/
    └── web.php                 # Seluruh routing aplikasi
```

---

## 🔄 Alur Sistem

```
Mahasiswa pilih stand
        ↓
Pilih menu → tambah ke keranjang
        ↓
Pilih tipe (Dine In + Meja / Take Away)
        ↓
Pilih metode bayar (Cash / QRIS)
        ↓
Konfirmasi pesanan → status: Pending
        ↓
Penjual update status: Diproses → Siap → Selesai
        ↓
Mahasiswa beri rating & ulasan
        ↓
Admin & Penjual lihat laporan penjualan
```

---

## 👨‍💻 Kontributor

Dikembangkan sebagai proyek mata kuliah Pemrograman Web.

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan akademik.
