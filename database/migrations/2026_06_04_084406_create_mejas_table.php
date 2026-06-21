<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mejas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor'); // contoh: "Meja 1", "Meja 2"
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });

        // Tambah kolom meja_id di tabel pesanans
        Schema::table('pesanans', function (Blueprint $table) {
            $table->foreignId('meja_id')->nullable()->constrained('mejas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['meja_id']);
            $table->dropColumn('meja_id');
        });
        Schema::dropIfExists('mejas');
    }
};