<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // === Seed Admin ===
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@nexusdesk.com',
            'role'     => 'admin',
            'phone'    => '081234567890',
            'password' => Hash::make('password'),
        ]);

        // === Seed User ===
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'user@nexusdesk.com',
            'role'     => 'user',
            'phone'    => '081298765432',
            'password' => Hash::make('password'),
        ]);

        // === Seed Kategori (akan digunakan setelah migration categories dibuat) ===
        // Kategori di-seed di Fase 2 setelah tabel categories dibuat.
    }
}
