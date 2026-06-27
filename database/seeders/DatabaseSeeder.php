<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\KnowledgeBase;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // === 1. Seed Categories ===
        $catHardware = Category::create([
            'name'        => 'hardware',
            'description' => 'Kendala perangkat keras seperti PC mati, printer rusak, monitor bergaris, keyboard error.',
        ]);

        $catSoftware = Category::create([
            'name'        => 'software',
            'description' => 'Kendala aplikasi, sistem operasi Windows/Mac, instalasi software, lisensi expired.',
        ]);

        $catNetwork = Category::create([
            'name'        => 'network',
            'description' => 'Kendala jaringan Wi-Fi putus, LAN lambat, VPN tidak bisa konek, akses internet terblokir.',
        ]);

        // === 2. Seed Users ===
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@nexusdesk.com',
            'role'     => 'admin',
            'phone'    => '081234567890',
            'password' => Hash::make('password'),
        ]);

        // Admin spesialisasi di hardware & network
        $admin->specializations()->attach([$catHardware->id, $catNetwork->id]);

        $user = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'user@nexusdesk.com',
            'role'     => 'user',
            'phone'    => '081298765432',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Siti Aminah',
            'email'    => 'siti@nexusdesk.com',
            'role'     => 'user',
            'phone'    => '081345678912',
            'password' => Hash::make('password'),
        ]);

        // === 3. Seed Website Settings ===
        WebsiteSetting::set('app_name', 'NexusDesk AI');
        WebsiteSetting::set('company_name', 'PT Nexus Corporate Technology');
        WebsiteSetting::set('support_email', 'helpdesk@nexusdesk.com');

        // === 4. Seed Knowledge Base (FAQ) ===
        KnowledgeBase::create([
            'question'    => 'Bagaimana cara mengatasi koneksi VPN yang gagal terhubung (Error 691/800)?',
            'answer'      => "1. Pastikan koneksi internet utama Anda stabil.\n2. Cek kembali Username dan Password VPN Anda (case sensitive).\n3. Disable sementara Antivirus atau Windows Defender Firewall yang mungkin memblokir port PPTP/L2TP.\n4. Restart service Client Remote Access di Services.msc.",
            'category_id' => $catNetwork->id,
            'is_active'   => true,
        ]);

        KnowledgeBase::create([
            'question'    => 'Printer kantor tidak bisa merespon saat mencetak dokumen (Print Job Stuck)',
            'answer'      => "1. Matikan printer dan cabut kabel USB/LAN selama 30 detik.\n2. Buka Services.msc di Windows, cari 'Print Spooler', klik kanan dan pilih Restart.\n3. Hapus seluruh antrean cetak yang tertahan di Devices and Printers.\n4. Nyalakan kembali printer.",
            'category_id' => $catHardware->id,
            'is_active'   => true,
        ]);

        KnowledgeBase::create([
            'question'    => 'Aplikasi Microsoft Office meminta aktivasi ulang / Lisensi Expired',
            'answer'      => "Silakan hubungi tim IT Helpdesk untuk melampirkan hostname PC Anda. Tim IT akan melakukan remote via AnyDesk untuk memasukkan product key perusahaan yang baru.",
            'category_id' => $catSoftware->id,
            'is_active'   => true,
        ]);

        // === 5. Seed Sample Tickets ===
        $ticket1 = Ticket::create([
            'user_id'           => $user->id,
            'category_id'       => $catHardware->id,
            'assigned_admin_id' => $admin->id,
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

        $ticket1->chatHistories()->create([
            'user_id'     => $admin->id,
            'sender_type' => 'admin',
            'message'     => 'Halo Pak Budi, kami sudah menerima tiketnya. Apakah sudah dicoba kencangkan kabel HDMI ke CPU?',
        ]);

        $ticket2 = Ticket::create([
            'user_id'           => $user->id,
            'category_id'       => $catNetwork->id,
            'assigned_admin_id' => $admin->id,
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
