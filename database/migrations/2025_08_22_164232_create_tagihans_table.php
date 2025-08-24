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

            // Relasi ke user (mahasiswa)
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Relasi ke periode (program + nominal SPP)
            $table->foreignId('periode_id')
                ->constrained('periodes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Relasi ke program studi
            $table->foreignId('program_studi_id')
                ->constrained('program_studis')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Nominal tagihan dan pembayaran
            $table->decimal('total_tagihan', 15, 2);
            $table->decimal('terbayar', 15, 2)->default(0);

            // Status pembayaran
            $table->enum('status', ['parsial','lunas'])
                  ->nullable();;

            $table->timestamps();
            $table->softDeletes();
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
