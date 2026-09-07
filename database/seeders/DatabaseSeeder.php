<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan akun default sukri dibuat
        $user = \App\Models\User::firstOrCreate(
            ['username' => 'sukri'],
            [
                'name' => 'Muhamad Sukri',
                'email' => 'sukri@example.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        // Tambahkan beberapa contoh tugas untuk sukri jika belum ada
        if ($user->todos()->count() === 0) {
            $user->todos()->createMany([
                [
                    'title' => 'Menyelesaikan laporan proyek TaskFlow',
                    'description' => 'Memastikan seluruh dokumentasi dan pengujian telah lengkap.',
                    'priority' => 'tinggi',
                    'due_date' => now()->addDays(2),
                    'is_completed' => false,
                ],
                [
                    'title' => 'Uji coba login admin dan panel pengguna',
                    'description' => 'Memeriksa akses read-only di panel admin.',
                    'priority' => 'sedang',
                    'due_date' => now()->addDays(3),
                    'is_completed' => true,
                ],
                [
                    'title' => 'Merapikan tata letak tampilan website',
                    'description' => 'Memeriksa kenyamanan saat zoom 100%.',
                    'priority' => 'rendah',
                    'due_date' => now()->addDays(5),
                    'is_completed' => false,
                ],
            ]);
        }
    }
}
