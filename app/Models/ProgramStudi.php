<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use SoftDeletes;

    protected $table = 'program_studis';

    protected $fillable = [
        'nama',
    ];

    // Relasi 1-N: ProgramStudi → Periodes
    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }
}
