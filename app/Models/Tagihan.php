<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tagihans';

    protected $fillable = [
        'user_id',
        'jenis_tagihan_id',
        'nim',
        'nama_mahasiswa',
        'program',
        'total_tagihan',
        'terbayar',
        'status',
        'tanggal_jatuh_tempo',
    ];

    // Relasi ke User (N:1)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke JenisTagihan (N:1)
    public function jenisTagihan()
    {
        return $this->belongsTo(JenisTagihan::class, 'jenis_tagihan_id');
    }

    // Relasi N-M ke Pembayaran (via Pivot)
    public function pembayarans()
    {
        return $this->belongsToMany(Pembayaran::class, 'pembayaran_tagihan', 'tagihan_id', 'pembayaran_id')
                    ->withPivot('nominal_teralokasi')
                    ->withTimestamps();
    }
}
