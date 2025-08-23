<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaStatus extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_statuses';

    protected $fillable = [
        'user_id',
        'status',
        'keterangan',
    ];

    /**
     * Relasi ke User (mahasiswa).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
