<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->enum('metode_bayar', ['cash', 'qris'])->default('cash')->after('total');
            $table->enum('status_bayar', ['belum_bayar', 'menunggu_konfirmasi', 'lunas'])->default('belum_bayar')->after('metode_bayar');
            $table->string('bukti_bayar')->nullable()->after('status_bayar'); // path foto bukti QRIS
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['metode_bayar', 'status_bayar', 'bukti_bayar']);
        });
    }
};