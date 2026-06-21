<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MejaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('mejas')->insert([
                'nomor'     => 'Meja ' . $i,
                'tersedia'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info('✅ 10 meja berhasil dibuat!');
    }
}