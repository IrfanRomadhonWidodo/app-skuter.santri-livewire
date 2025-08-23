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
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->string('kode'); // ex: 2025-2026-1
            $table->string('program'); // disamakan dengan kolom di users
            $table->decimal('nominal_default', 15, 2); // default per prodi
            $table->date('periode_mulai')->nullable(); // opsional (untuk info rentang)
            $table->date('periode_selesai')->nullable(); // opsional
            $table->timestamps();

            $table->unique(['kode', 'program']); // 1 kode unik per prodi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }

};
