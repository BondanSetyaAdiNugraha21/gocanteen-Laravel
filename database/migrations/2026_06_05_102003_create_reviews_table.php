<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->tinyInteger('rating'); // 1-5
            $table->text('komentar')->nullable();
            $table->timestamps();
            $table->unique(['pesanan_id', 'menu_id']); // 1 review per menu per pesanan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};