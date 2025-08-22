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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id') // mahasiswa
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignId('jenis_tagihan_id')
                  ->constrained('jenis_tagihans')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->string('nim');             // snapshot stabil di laporan
            $table->string('nama_mahasiswa');  // snapshot
            $table->string('program');         // snapshot

            $table->decimal('total_tagihan', 15, 2); 
            $table->decimal('terbayar', 15, 2)->default(0);

            $table->enum('status', ['diproses','disetujui','ditolak','parsial','lunas'])
                  ->default('diproses');

            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->timestamps(); 
            $table->softDeletes();

            $table->unique(['user_id', 'jenis_tagihan_id']); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
