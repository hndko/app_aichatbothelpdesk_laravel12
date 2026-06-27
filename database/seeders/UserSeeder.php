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
        $catSoftware = Category::where('name', 'software')->first();
        $catNetwork  = Category::where('name', 'network')->first();

        // 1. Admin
        $admin = User::firstOrCreate(['email' => 'admin@example.com'], [
            'name'     => 'Administrator',
            'role'     => 'admin',
            'phone'    => '081234567890',
            'password' => Hash::make('password'),
        ]);

        // 2. Service Desk
        User::firstOrCreate(['email' => 'servicedesk@example.com'], [
            'name'     => 'Rina Service Desk',
            'role'     => 'service_desk',
            'phone'    => '081211112222',
            'password' => Hash::make('password'),
        ]);

        // 3. Helpdesk 1 (Hardware & Network Specialist)
        $hd1 = User::firstOrCreate(['email' => 'helpdesk1@example.com'], [
            'name'     => 'Agus Helpdesk (HW & Net)',
            'role'     => 'helpdesk',
            'phone'    => '081233334444',
            'password' => Hash::make('password'),
        ]);
        if ($catHardware && $catNetwork) {
            $hd1->specializations()->syncWithoutDetaching([$catHardware->id, $catNetwork->id]);
        }

        // 4. Helpdesk 2 (Software Specialist)
        $hd2 = User::firstOrCreate(['email' => 'helpdesk2@example.com'], [
            'name'     => 'Dewi Helpdesk (Software)',
            'role'     => 'helpdesk',
            'phone'    => '081255556666',
            'password' => Hash::make('password'),
        ]);
        if ($catSoftware) {
            $hd2->specializations()->syncWithoutDetaching([$catSoftware->id]);
        }

        // 5. Users biasa
        User::firstOrCreate(['email' => 'user@example.com'], [
            'name'     => 'Budi Santoso',
            'role'     => 'user',
            'phone'    => '081298765432',
            'password' => Hash::make('password'),
        ]);

        User::firstOrCreate(['email' => 'siti@example.com'], [
            'name'     => 'Siti Aminah',
            'role'     => 'user',
            'phone'    => '081345678912',
            'password' => Hash::make('password'),
        ]);
    }
}
