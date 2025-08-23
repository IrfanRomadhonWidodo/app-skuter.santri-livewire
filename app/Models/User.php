<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'nim',
        'program',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- Custom Method ---
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    // --- Relasi ---

    // 1-N: User → Tagihans
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    // 1-N: User → Pembayarans (mahasiswa yang bayar)
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'mahasiswa_id');
    }

    // 1-N: User → Pembayaran diterima (penerima/admin)
    public function pembayaranDiterima()
    {
        return $this->hasMany(Pembayaran::class, 'penerima_id');
    }

    public function mahasiswaStatus()
    {
        return $this->hasOne(MahasiswaStatus::class);
    }

    // 1-1 atau 1-N: User → Beasiswas (sesuai kebutuhan)
    // public function beasiswas()
    // {
    //     return $this->hasMany(Beasiswa::class);
    //     // kalau 1-1 ganti dengan:
    //     // return $this->hasOne(Beasiswa::class, 'user_id');
    // }
}
