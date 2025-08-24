<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'periode_id',
        'nim',
        'nama_mahasiswa',
        'program',
        'total_tagihan',
        'terbayar',
        'status',
    ];

    // Relasi ke User (mahasiswa)
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Periode
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function pembayaranTagihan()
    {
        return $this->hasMany(PembayaranTagihan::class);
    }

    // Relasi ke Pembayaran via pivot
    public function pembayarans()
    {
        return $this->belongsToMany(Pembayaran::class, 'pembayaran_tagihan', 'tagihan_id', 'pembayaran_id')
                    ->withPivot('nominal_teralokasi')
                    ->withTimestamps();
    }

    // Helper sisa tagihan
    public function getSisaAttribute()
    {
        return $this->total_tagihan - $this->terbayar;
    }

    // Auto-generate tagihan untuk periode baru
    public static function generateForPeriode($periode)
    {
        $mahasiswas = User::where('role', 'mahasiswa')
                          ->where('program_studi_id', $periode->programStudi->id)
                          ->whereHas('mahasiswaStatus', fn($q) => $q->whereIn('status', ['aktif', 'cuti']))
                          ->get();

        foreach ($mahasiswas as $mhs) {
            self::updateOrCreate(
                ['user_id' => $mhs->id, 'periode_id' => $periode->id],
                [
                    'nim' => $mhs->nim,
                    'nama_mahasiswa' => $mhs->name,
                    'program_studi_id' => $mhs->program_studi_id,
                    'total_tagihan' => $periode->nominal_awal,
                    'terbayar' => 0,
                    'status' => null,
                ]
            );
        }
    }
}