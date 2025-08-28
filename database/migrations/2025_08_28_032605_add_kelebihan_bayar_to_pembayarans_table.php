<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->decimal('kelebihan_bayar', 15, 2)->default(0)->after('catatan');
        });

        Schema::table('tagihans', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('user_id');
            $table->string('nama_mahasiswa')->nullable()->after('nim');
            $table->string('program')->nullable()->after('nama_mahasiswa');
            $table->decimal('sisa', 15, 2)->default(0)->after('terbayar');
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('kelebihan_bayar');
        });

        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropColumn(['nim', 'nama_mahasiswa', 'program', 'sisa']);
        });
    }
};