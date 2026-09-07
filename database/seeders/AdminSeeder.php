<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Akun Admin Bawaan
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator TaskFlow',
                'email' => 'admin@taskflow.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Buat Akun Pengguna Biasa Contoh
        User::firstOrCreate(
            ['username' => 'sukri'],
            [
                'name' => 'Muhamad Sukri',
                'email' => 'sukri@taskflow.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );
    }
}
