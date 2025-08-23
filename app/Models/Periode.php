<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periodes';

    protected $fillable = [
        'kode',
        'program',
        'nominal_default',
        'periode_mulai',
        'periode_selesai',
    ];

    protected $casts = [
        'periode_mulai'   => 'date',
        'periode_selesai' => 'date',
    ];

    // Relasi 1-N: JenisTagihan → Tagihans
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'jenis_tagihan_id');
    }
}
