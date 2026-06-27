<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name'        => 'hardware',
            'description' => 'Kendala perangkat keras seperti PC mati, printer rusak, monitor bergaris, keyboard error.',
        ]);

        Category::create([
            'name'        => 'software',
            'description' => 'Kendala aplikasi, sistem operasi Windows/Mac, instalasi software, lisensi expired.',
        ]);

        Category::create([
            'name'        => 'network',
            'description' => 'Kendala jaringan Wi-Fi putus, LAN lambat, VPN tidak bisa konek, akses internet terblokir.',
        ]);
    }
}
