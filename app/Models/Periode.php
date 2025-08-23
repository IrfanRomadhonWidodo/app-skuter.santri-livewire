<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'periodes';

    protected $fillable = [
        'kode',
        'program_studi_id',
        'nominal_awal',
        'periode_mulai',
        'periode_selesai',
    ];

    protected $casts = [
        'periode_mulai'   => 'date',
        'periode_selesai' => 'date',
    ];

    // Relasi N-1: Periode → ProgramStudi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    // Relasi 1-N: JenisTagihan → Tagihans
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }
}
