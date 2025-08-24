<?php

namespace Database\Seeders;

use App\Models\MahasiswaStatus;
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
            ]
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }

        // Mahasiswa
        $mahasiswa = [
            [
                'name' => 'Essay Bina',
                'email' => 'essaybina31@unu.ac.id',
                'nim' => '2025001114',
                'password' => Hash::make('bina123'),
                'role' => 'mahasiswa',
                'program_studi_id' => 1,
            ],
            [
                'name' => 'Meiliana Tita',
                'email' => 'meilianatita@unu.ac.id',
                'nim' => '2025002115',
                'password' => Hash::make('meili123'),
                'role' => 'mahasiswa',
                'program_studi_id' => 2,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budisantoso@unu.ac.id',
                'nim' => '2025003116',
                'password' => Hash::make('budi123'),
                'role' => 'mahasiswa',
                'program_studi_id' => 1,
            ],
            [
                'name' => 'Dewi Sartika',
                'email' => 'dewisartika@unu.ac.id',
                'nim' => '2025004117',
                'password' => Hash::make('dewi123'),
                'role' => 'mahasiswa',
                'program_studi_id' => 2,
            ]
        ];

        foreach ($mahasiswa as $mhs) {
            $user = User::create($mhs);

            MahasiswaStatus::create([
                'mahasiswa_id' => $user->id,
                'status' => 'aktif', // atau 'cuti' sesuai kebutuhan
            ]);
        }
    }
}
