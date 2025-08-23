<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembayarans';

    protected $fillable = [
        'mahasiswa_id',
        'penerima_id',
        'tanggal_bayar',
        'jumlah',
        'cara_bayar',
        'bukti_pembayaran',
        'kwitansi',
        'status',
        'approved_at',
    ];

    // Relasi ke User (mahasiswa yang bayar)
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // Relasi ke User (penerima/admin)
    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }

    // Relasi N-M ke Tagihan (via Pivot)
    public function tagihans()
    {
        return $this->belongsToMany(Tagihan::class, 'pembayaran_tagihan', 'pembayaran_id', 'tagihan_id')
                    ->withPivot('nominal_teralokasi')
                    ->withTimestamps();
    }
}
