<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catHardware = Category::where('name', 'hardware')->first();
        $catNetwork  = Category::where('name', 'network')->first();

        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@example.com',
            'role'     => 'admin',
            'phone'    => '081234567890',
            'password' => Hash::make('password'),
        ]);

        if ($catHardware && $catNetwork) {
            $admin->specializations()->attach([$catHardware->id, $catNetwork->id]);
        }

        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'user@example.com',
            'role'     => 'user',
            'phone'    => '081298765432',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Siti Aminah',
            'email'    => 'siti@example.com',
            'role'     => 'user',
            'phone'    => '081345678912',
            'password' => Hash::make('password'),
        ]);
    }
}
