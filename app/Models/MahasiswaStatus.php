<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mahasiswa_statuses';

    protected $fillable = [
        'mahasiswa_id',
        'status',
        'keterangan',
    ];

    /**
     * Relasi ke User (mahasiswa).
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
