<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembayaranTagihan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembayaran_tagihan';

    protected $fillable = [
        'pembayaran_id',
        'tagihan_id',
        'nominal_teralokasi',
    ];

    // Relasi ke Pembayaran
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    // Relasi ke Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
