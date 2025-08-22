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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id') // mahasiswa yang bayar
                  ->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('penerima_id') // petugas/admin yang menerima
                  ->constrained('users')->cascadeOnUpdate()->restrictOnDelete();

            $table->date('tanggal_bayar')->nullable(); // dari form
            $table->decimal('jumlah', 15, 2); // berapa yang disetor user (parsial boleh)
            $table->string('cara_bayar'); // transfer/cash/dll (boleh nanti diganti enum)
            $table->string('bukti_pembayaran')->nullable(); // path JPG/PNG
            $table->string('kwitansi')->nullable(); // path PDF/IMG kwitansi setelah ACC

            $table->enum('status', ['menunggu','disetujui','ditolak'])->default('menunggu');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
