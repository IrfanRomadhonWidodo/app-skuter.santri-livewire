<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admins = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Irfan Romadhon',
                'email' => 'irfanromadhonwidodo86@gmail.com',
                'password' => Hash::make('irfan123'),
                'role' => 'admin',
            ],
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }

        // Mahasiswa
        $mahasiswas = [
            [
                'name' => 'Essay Bina',
                'email' => 'essaybina31@unu.ac.id',
                'nim' => '2025001114',
                'program_studi_id' => 1,
                'password' => Hash::make('bina123'),
                'role' => 'mahasiswa',
            ],
            [
                'name' => 'Meilianatita',
                'email' => 'meilianatita@unu.ac.id',
                'nim' => '2025002115',
                'program_studi_id' => 2,
                'password' => Hash::make('meili123'),
                'role' => 'mahasiswa',
            ],
            [
                'name' => 'Rizky Maulana',
                'email' => 'rizkymaulana@unu.ac.id',
                'nim' => '2025003116',
                'program_studi_id' => 3,
                'password' => Hash::make('rizky123'),
                'role' => 'mahasiswa',
            ],
            [
                'name' => 'Diana',
                'email' => 'diana@unu.ac.id',
                'nim' => '2025004117',
                'program_studi_id' => 4,
                'password' => Hash::make('diana123'),
                'role' => 'mahasiswa',
            ],
        ];

        foreach ($mahasiswas as $mahasiswa) {
            User::create($mahasiswa);
        }
    }
}
