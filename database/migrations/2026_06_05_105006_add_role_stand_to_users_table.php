<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'penjual'])->default('admin')->after('email');
            $table->foreignId('stand_id')->nullable()->constrained('stands')->onDelete('set null')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['stand_id']);
            $table->dropColumn(['role', 'stand_id']);
        });
    }
};