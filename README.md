#  Go.Canteen — Laravel CRUD Menu

Implementasi fitur CRUD Menu dari project Go.Canteen menggunakan Laravel 10.

##  Deskripsi

Go.Canteen adalah sistem informasi pemesanan kantin berbasis web untuk mendukung ekonomi digital di lingkungan kampus. Project ini merupakan implementasi ulang fitur **Kelola Menu** dari project UTS Go.Canteen (PHP Native) ke dalam framework **Laravel 10**.

##  Fitur

-  **Create** — Tambah menu baru dengan nama, deskripsi, harga, stok, emoji, dan kategori
-  **Read** — Menampilkan daftar semua menu dalam bentuk tabel
-  **Update** — Edit data menu yang sudah ada
-  **Delete** — Hapus menu dengan konfirmasi

##  Tech Stack

- **Framework** : Laravel 10
- **Language** : PHP 8.2
- **Database** : MySQL (XAMPP)
- **Frontend** : Blade Template + Tailwind CSS (CDN)
- **Tools** : Composer, PHP Artisan

##  Struktur Database

Tabel `menus`:
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| nama | varchar | Nama menu |
| deskripsi | text | Deskripsi menu |
| harga | integer | Harga menu |
| emoji | varchar | Emoji menu |
| stok | integer | Jumlah stok |
| kategori_id | integer | ID kategori |
| tersedia | boolean | Status ketersediaan |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

##  Akses 

1. Buka `http://127.0.0.1:8000/menu`

##  Developer

- **Nama:** Bondan Setya Adi Nugraha
- **NPM:** 24082010255
- **Kelas:** 4-F
- **Mata Kuliah:** Pemrograman Web
