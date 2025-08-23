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

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Periode
    public function periode()
    {
        return $this->belongsTo(Periode::class);
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

    // Scope mahasiswa aktif
    public function scopeAktif($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('role', 'mahasiswaStatus')
              ->whereIn('status', ['aktif', 'cuti']); // Termasuk cuti
        });
    }

    // Auto-generate tagihan untuk periode baru
    public static function generateForPeriode($periode)
    {
        $mahasiswas = User::where('role', 'mahasiswa')
                          ->where('program', $periode->program)
                          ->whereHas('mahasiswaStatus', fn($q) => $q->whereIn('status', ['aktif', 'cuti']))
                          ->get();

        foreach ($mahasiswas as $mhs) {
            self::updateOrCreate(
                ['user_id' => $mhs->id, 'periode_id' => $periode->id],
                [
                    'nim' => $mhs->mahasiswaStatus->nim ?? $mhs->nim,
                    'nama_mahasiswa' => $mhs->name,
                    'program' => $mhs->program,
                    'total_tagihan' => $periode->nominal,
                    'terbayar' => 0,
                    'status' => null,
                ]
            );
        }
    }
}
