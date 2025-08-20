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
        // Mahasiswa
        User::create([
            'name' => 'Essay Bina',
            'email' => 'essaybina30@example.com',
            'password' => Hash::make('bina123'), 
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
