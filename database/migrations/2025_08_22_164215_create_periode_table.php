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
            $table->string('kode')->unique(); // ex: 2025-2026-1
            $table->foreignId('program_studi_id')->constrained('program_studis')->onDelete('cascade');
            $table->decimal('nominal_awal', 15, 2); // default per prodi
            $table->date('periode_mulai')->nullable(); // opsional (untuk info rentang)
            $table->date('periode_selesai')->nullable(); // opsional
            $table->timestamps();
            $table->softDeletes();
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
