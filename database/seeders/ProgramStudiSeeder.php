<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programStudi = [
            ['nama' => 'Administrasi Publik'],
            ['nama' => 'Agroteknologi'],
            ['nama' => 'Akuntansi'],
            ['nama' => 'Biologi'],
            ['nama' => 'Hukum Syariah'],
            ['nama' => 'Ilmu Hukum'],
            ['nama' => 'Ilmu Perikanan'],
            ['nama' => 'Manajemen'],
            ['nama' => 'Matematika'],
            ['nama' => 'Pendidikan Agama Islam'],
            ['nama' => 'Pendidikan Bahasa Inggris'],
            ['nama' => 'Peternakan'],
            ['nama' => 'Teknik Pertanian dan Biosistem'],
            ['nama' => 'Teknologi Pangan'],
        ];

        foreach ($programStudi as $prodi) {
            ProgramStudi::create($prodi);
        }
    }
}
