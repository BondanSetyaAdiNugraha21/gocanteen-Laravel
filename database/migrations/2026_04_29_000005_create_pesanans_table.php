<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->foreignId('stand_id')->constrained()->onDelete('cascade');
            $table->enum('tipe', ['dine-in', 'takeaway'])->default('dine-in');
            $table->string('info')->nullable();
            $table->integer('total')->default(0);
            $table->enum('status', ['pending', 'diproses', 'siap', 'selesai', 'dibatalkan'])->default('pending');
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
