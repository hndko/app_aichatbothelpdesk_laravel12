<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $user  = User::where('role', 'user')->first();

        $catHardware = Category::where('name', 'hardware')->first();
        $catNetwork  = Category::where('name', 'network')->first();

        if (!$user || !$catHardware || !$catNetwork) {
            return;
        }

        $ticket1 = Ticket::create([
            'user_id'           => $user->id,
            'category_id'       => $catHardware->id,
            'assigned_admin_id' => $admin ? $admin->id : null,
            'subject'           => 'Monitor PC bergaris hijau dan berkedip',
            'description'       => 'Sejak pagi tadi saat menyalakan PC, layar monitor bagian kanan muncul garis hijau vertikal yang terus berkedip.',
            'priority'          => 'high',
            'status'            => 'progress',
            'sentiment'         => 'negative',
        ]);

        $ticket1->chatHistories()->create([
            'user_id'     => $user->id,
            'sender_type' => 'user',
            'message'     => 'Sejak pagi tadi saat menyalakan PC, layar monitor bagian kanan muncul garis hijau vertikal yang terus berkedip.',
        ]);

        if ($admin) {
            $ticket1->chatHistories()->create([
                'user_id'     => $admin->id,
                'sender_type' => 'admin',
                'message'     => 'Halo Pak Budi, kami sudah menerima tiketnya. Apakah sudah dicoba kencangkan kabel HDMI ke CPU?',
            ]);
        }

        $ticket2 = Ticket::create([
            'user_id'           => $user->id,
            'category_id'       => $catNetwork->id,
            'assigned_admin_id' => $admin ? $admin->id : null,
            'subject'           => 'Koneksi Wi-Fi di lantai 2 sering putus',
            'description'       => 'Saat meeting Zoom di ruang meeting lantai 2, koneksi berkali-kali disconnect.',
            'priority'          => 'medium',
            'status'            => 'open',
            'sentiment'         => 'neutral',
        ]);

        $ticket2->chatHistories()->create([
            'user_id'     => $user->id,
            'sender_type' => 'user',
            'message'     => 'Saat meeting Zoom di ruang meeting lantai 2, koneksi berkali-kali disconnect.',
        ]);
    }
}
