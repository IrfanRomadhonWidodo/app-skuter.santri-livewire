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
        Schema::create('pembayaran_tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')
                ->unique()
                ->constrained('pembayarans')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('tagihan_id')
                ->unique()
                ->constrained('tagihans')->cascadeOnUpdate()->cascadeOnDelete();

            $table->decimal('nominal_teralokasi', 15, 2); // bagian dari pembayaran ini untuk tagihan tsb
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_tagihan');
    }
};
