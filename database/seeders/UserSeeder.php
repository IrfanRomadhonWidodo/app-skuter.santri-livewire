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
        User::create([
            'name' => 'Essay Bina',
            'email' => 'essaybina31@unu.ac.id',
            'nim' => '2025001114',
            'program' => 'Biologi',
            'password' => Hash::make('bina123'), 
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Meiliana Tita',
            'email' => 'meilianatita@unu.ac.id',
            'nim' => '2025002115',
            'program' => 'Biologi',
            'password' => Hash::make('meili123'),
            'role' => 'mahasiswa',
        ]);

        // Admin
        User::create([
            'name' => 'Irfan Romadhon',
            'email' => 'irfanromadhonwidodo86@gmail.com',
            'password' => Hash::make('irfan123'),
            'role' => 'admin',
        ]);
    }
}
