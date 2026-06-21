<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // STANDS
        // =====================
        $stands = [
            [
                'nama'      => 'Dapur Nusantara',
                'deskripsi' => 'Hidangan makanan berat khas Indonesia yang mengenyangkan',
                'emoji'     => '🍛',
                'aktif'     => true,
            ],
            [
                'nama'      => 'Segar Rasa',
                'deskripsi' => 'Aneka minuman segar dan menyegarkan untuk melepas dahaga',
                'emoji'     => '🧋',
                'aktif'     => true,
            ],
            [
                'nama'      => 'Camilan Josjis',
                'deskripsi' => 'Berbagai jajanan dan camilan enak untuk teman santai',
                'emoji'     => '🍿',
                'aktif'     => true,
            ],
        ];

        DB::table('stands')->insert(array_map(function ($s) {
            return array_merge($s, ['created_at' => now(), 'updated_at' => now()]);
        }, $stands));

        $standDapur   = DB::table('stands')->where('nama', 'Dapur Nusantara')->first()->id;
        $standSegar   = DB::table('stands')->where('nama', 'Segar Rasa')->first()->id;
        $standCamilan = DB::table('stands')->where('nama', 'Camilan Josjis')->first()->id;

        // =====================
        // KATEGORIS
        // =====================
        $kategoris = [
            ['nama' => 'Nasi & Lauk',   'emoji' => '🍚'],
            ['nama' => 'Mie & Pasta',   'emoji' => '🍜'],
            ['nama' => 'Minuman Dingin', 'emoji' => '🧊'],
            ['nama' => 'Minuman Hangat', 'emoji' => '☕'],
            ['nama' => 'Gorengan',       'emoji' => '🫔'],
            ['nama' => 'Kue & Roti',     'emoji' => '🧁'],
        ];

        DB::table('kategoris')->insert(array_map(function ($k) {
            return array_merge($k, ['created_at' => now(), 'updated_at' => now()]);
        }, $kategoris));

        $katNasi    = DB::table('kategoris')->where('nama', 'Nasi & Lauk')->first()->id;
        $katMie     = DB::table('kategoris')->where('nama', 'Mie & Pasta')->first()->id;
        $katDingin  = DB::table('kategoris')->where('nama', 'Minuman Dingin')->first()->id;
        $katHangat  = DB::table('kategoris')->where('nama', 'Minuman Hangat')->first()->id;
        $katGoreng  = DB::table('kategoris')->where('nama', 'Gorengan')->first()->id;
        $katKue     = DB::table('kategoris')->where('nama', 'Kue & Roti')->first()->id;

        // =====================
        // MENUS
        // =====================
        $menus = [
            // --- Dapur Nusantara (Makanan) ---
            ['stand_id' => $standDapur, 'kategori_id' => $katNasi, 'nama' => 'Nasi Goreng Spesial',    'deskripsi' => 'Nasi goreng dengan telur, ayam, dan sayuran segar',     'harga' => 15000, 'emoji' => '🍳', 'stok' => 30],
            ['stand_id' => $standDapur, 'kategori_id' => $katNasi, 'nama' => 'Nasi Ayam Penyet',       'deskripsi' => 'Ayam penyet sambal bawang dengan lalapan segar',         'harga' => 18000, 'emoji' => '🍗', 'stok' => 25],
            ['stand_id' => $standDapur, 'kategori_id' => $katNasi, 'nama' => 'Nasi Rendang',           'deskripsi' => 'Nasi putih dengan rendang daging sapi empuk berbumbu',   'harga' => 20000, 'emoji' => '🥩', 'stok' => 20],
            ['stand_id' => $standDapur, 'kategori_id' => $katNasi, 'nama' => 'Nasi Telur Balado',      'deskripsi' => 'Telur balado pedas dengan nasi hangat dan lauk tambahan', 'harga' => 13000, 'emoji' => '🥚', 'stok' => 35],
            ['stand_id' => $standDapur, 'kategori_id' => $katMie,  'nama' => 'Mie Ayam Bakso',        'deskripsi' => 'Mie kenyal dengan topping ayam cincang dan bakso',        'harga' => 14000, 'emoji' => '🍜', 'stok' => 28],
            ['stand_id' => $standDapur, 'kategori_id' => $katMie,  'nama' => 'Mie Goreng Pedas',      'deskripsi' => 'Mie goreng level pedas dengan telur dan sayuran',         'harga' => 13000, 'emoji' => '🌶️', 'stok' => 30],

            // --- Segar Rasa (Minuman) ---
            ['stand_id' => $standSegar, 'kategori_id' => $katDingin, 'nama' => 'Es Teh Manis',         'deskripsi' => 'Teh manis segar dengan es batu',                          'harga' => 5000,  'emoji' => '🍵', 'stok' => 50],
            ['stand_id' => $standSegar, 'kategori_id' => $katDingin, 'nama' => 'Es Jeruk Peras',       'deskripsi' => 'Jeruk peras segar dengan es batu tanpa pengawet',         'harga' => 8000,  'emoji' => '🍊', 'stok' => 40],
            ['stand_id' => $standSegar, 'kategori_id' => $katDingin, 'nama' => 'Jus Alpukat',          'deskripsi' => 'Jus alpukat creamy dengan susu dan gula aren',            'harga' => 12000, 'emoji' => '🥑', 'stok' => 25],
            ['stand_id' => $standSegar, 'kategori_id' => $katDingin, 'nama' => 'Es Boba Coklat',       'deskripsi' => 'Minuman boba susu coklat dengan mutiara kenyal',          'harga' => 15000, 'emoji' => '🧋', 'stok' => 30],
            ['stand_id' => $standSegar, 'kategori_id' => $katDingin, 'nama' => 'Es Cincau Hijau',      'deskripsi' => 'Cincau hijau segar dengan santan dan gula merah',         'harga' => 7000,  'emoji' => '🌿', 'stok' => 35],
            ['stand_id' => $standSegar, 'kategori_id' => $katHangat, 'nama' => 'Kopi Susu Hangat',     'deskripsi' => 'Kopi robusta dengan susu kental manis hangat',            'harga' => 10000, 'emoji' => '☕', 'stok' => 30],
            ['stand_id' => $standSegar, 'kategori_id' => $katHangat, 'nama' => 'Teh Tarik',            'deskripsi' => 'Teh tarik ala Malaysia yang creamy dan harum',            'harga' => 9000,  'emoji' => '🫖', 'stok' => 30],

            // --- Camilan Josjis (Jajanan) ---
            ['stand_id' => $standCamilan, 'kategori_id' => $katGoreng, 'nama' => 'Pisang Goreng Keju',  'deskripsi' => 'Pisang goreng renyah dengan taburan keju mozzarella',    'harga' => 8000,  'emoji' => '🍌', 'stok' => 40],
            ['stand_id' => $standCamilan, 'kategori_id' => $katGoreng, 'nama' => 'Tahu Crispy Pedas',   'deskripsi' => 'Tahu goreng crispy dengan bumbu balado pedas',           'harga' => 7000,  'emoji' => '🧆', 'stok' => 45],
            ['stand_id' => $standCamilan, 'kategori_id' => $katGoreng, 'nama' => 'Cireng Isi Keju',     'deskripsi' => 'Cireng kenyal dengan isian keju leleh di dalam',         'harga' => 8000,  'emoji' => '🫓', 'stok' => 40],
            ['stand_id' => $standCamilan, 'kategori_id' => $katGoreng, 'nama' => 'Tempe Mendoan',       'deskripsi' => 'Tempe tipis dibalut tepung gurih setengah matang',       'harga' => 5000,  'emoji' => '🟫', 'stok' => 50],
            ['stand_id' => $standCamilan, 'kategori_id' => $katKue,    'nama' => 'Martabak Mini Coklat','deskripsi' => 'Martabak manis mini isi coklat meses lumer',             'harga' => 10000, 'emoji' => '🍫', 'stok' => 25],
            ['stand_id' => $standCamilan, 'kategori_id' => $katKue,    'nama' => 'Roti Bakar Susu',     'deskripsi' => 'Roti bakar tebal dengan mentega dan susu kental manis', 'harga' => 9000,  'emoji' => '🍞', 'stok' => 30],
        ];

        DB::table('menus')->insert(array_map(function ($m) {
            return array_merge($m, ['tersedia' => true, 'created_at' => now(), 'updated_at' => now()]);
        }, $menus));

        // =====================
        // ADMIN USER
        // =====================
        if (DB::table('users')->count() === 0) {
            DB::table('users')->insert([
                'name'       => 'Admin',
                'email'      => 'admin@gocanteen.com',
                'password'   => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Seeder berhasil! Data stand, kategori, dan menu sudah masuk.');
    }
}