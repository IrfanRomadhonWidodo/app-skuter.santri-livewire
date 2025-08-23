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
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignId('penerima_id') // petugas/admin yang menerima
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->date('tanggal_bayar'); // dari form
            $table->decimal('jumlah', 15, 2); // nominal bayar (parsial boleh)
            $table->enum('cara_bayar', ['transfer', 'cash', 'alokasi']); // metode bayar
            $table->string('bukti_pembayaran')->nullable(); // file bukti JPG/PNG
            $table->string('kwitansi')->nullable(); // path kwitansi PDF/IMG setelah ACC
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
