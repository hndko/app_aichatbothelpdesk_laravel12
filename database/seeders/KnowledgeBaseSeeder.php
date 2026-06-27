<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\KnowledgeBase;
use Illuminate\Database\Seeder;

class KnowledgeBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catHardware = Category::where('name', 'hardware')->first();
        $catSoftware = Category::where('name', 'software')->first();
        $catNetwork  = Category::where('name', 'network')->first();

        $idHardware = $catHardware ? $catHardware->id : 1;
        $idSoftware = $catSoftware ? $catSoftware->id : 2;
        $idNetwork  = $catNetwork ? $catNetwork->id : 3;

        $faqs = [
            // --- NETWORK (7 items) ---
            [
                'question'    => 'Bagaimana cara mengatasi koneksi VPN yang gagal terhubung (Error 691/800)?',
                'answer'      => "1. Pastikan koneksi internet utama Anda stabil.\n2. Cek kembali Username dan Password VPN Anda (case sensitive).\n3. Disable sementara Antivirus atau Windows Defender Firewall yang mungkin memblokir port PPTP/L2TP.\n4. Restart service Client Remote Access di Services.msc.",
                'category_id' => $idNetwork,
            ],
            [
                'question'    => 'Koneksi Wi-Fi kantor sering putus nyambung saat zoom meeting',
                'answer'      => "1. Cobalah berpindah posisi lebih dekat ke access point Wi-Fi lantai Anda.\n2. Lupakan jaringan (Forget Network) pada Wi-Fi kantor, lalu sambungkan ulang.\n3. Gunakan jaringan frekuensi 5GHz jika perangkat mendukung untuk menghindari interferensi sinyal.\n4. Jika masih berlanjut, gunakan kabel LAN Ethernet.",
                'category_id' => $idNetwork,
            ],
            [
                'question'    => 'Tidak bisa mengakses portal internal intranet perusahaan (Error 404 / Timeout)',
                'answer'      => "1. Pastikan Anda terhubung ke jaringan Wi-Fi kantor atau VPN aktif jika bekerja dari rumah (WFH).\n2. Bersihkan cache dan cookies browser Anda atau coba gunakan mode Incognito/Private Window.\n3. Periksa pengaturan DNS komputer, pastikan diatur ke Automatic (DHCP).",
                'category_id' => $idNetwork,
            ],
            [
                'question'    => 'Bagaimana cara setting proxy LAN pada browser Windows?',
                'answer'      => "1. Buka menu Settings Windows > Network & Internet > Proxy.\n2. Pada bagian Manual Proxy Setup, aktifkan toggle 'Use a proxy server'.\n3. Masukkan alamat IP proxy kantor dan port yang telah ditentukan oleh IT Helpdesk.\n4. Klik Save dan restart browser Anda.",
                'category_id' => $idNetwork,
            ],
            [
                'question'    => 'Kecepatan internet LAN terasa sangat lambat padahal koneksi stabil',
                'answer'      => "1. Periksa kabel LAN apakah tertekuk atau konektor RJ45 longgar.\n2. Buka Task Manager > tab Performance > Network untuk melihat apakah ada aplikasi latar belakang yang melakukan pembaruan besar (Windows Update / Cloud Sync).\n3. Coba pindahkan port kabel LAN ke soket dinding yang lain.",
                'category_id' => $idNetwork,
            ],
            [
                'question'    => 'Cara mendapatkan akses Wi-Fi khusus tamu untuk klien eksternal',
                'answer'      => "1. Silakan hubungi resepsionis atau buat tiket ke IT Helpdesk dengan melampirkan nama tamu dan instansi.\n2. Tim IT akan memberikan Voucher Code Wi-Fi Guest yang berlaku selama 24 jam.\n3. Tamu dapat login melalui captive portal saat terhubung ke SSID 'MariDesk-Guest'.",
                'category_id' => $idNetwork,
            ],
            [
                'question'    => 'Alamat IP komputer mengalami konflik (IP Address Conflict)',
                'answer'      => "1. Buka Command Prompt (cmd) sebagai Administrator.\n2. Ketik perintah: ipconfig /release lalu tekan Enter.\n3. Tunggu beberapa detik, kemudian ketik: ipconfig /renew lalu tekan Enter.\n4. Restart komputer jika pesan error masih muncul.",
                'category_id' => $idNetwork,
            ],

            // --- HARDWARE (7 items) ---
            [
                'question'    => 'Printer kantor tidak bisa merespon saat mencetak dokumen (Print Job Stuck)',
                'answer'      => "1. Matikan printer dan cabut kabel USB/LAN selama 30 detik.\n2. Buka Services.msc di Windows, cari 'Print Spooler', klik kanan dan pilih Restart.\n3. Hapus seluruh antrean cetak yang tertahan di Devices and Printers.\n4. Nyalakan kembali printer.",
                'category_id' => $idHardware,
            ],
            [
                'question'    => 'Layar monitor PC tiba-tiba bergaris vertikal atau berkedip (Flickering)',
                'answer'      => "1. Periksa kabel display (HDMI/DisplayPort/VGA) di belakang monitor dan CPU, pastikan tertancap kuat.\n2. Coba update driver kartu grafis (GPU) melalui Device Manager.\n3. Ubah Refresh Rate monitor di Display Settings ke standar 60Hz atau 75Hz.\n4. Jika layar tetap bergaris saat diuji di PC lain, buat tiket penggantian perangkat hardware.",
                'category_id' => $idHardware,
            ],
            [
                'question'    => 'Keyboard atau mouse wireless tidak berfungsi sama sekali',
                'answer'      => "1. Periksa kondisi baterai pada keyboard atau mouse wireless Anda, ganti dengan baterai baru.\n2. Cabut USB receiver dongle dan colokkan kembali ke port USB yang berbeda.\n3. Pastikan tombol saklar daya (On/Off) di bagian bawah mouse/keyboard sudah dinyalakan.",
                'category_id' => $idHardware,
            ],
            [
                'question'    => 'Komputer laptop cepat panas (Overheating) dan kipas berisik',
                'answer'      => "1. Pastikan ventilasi udara laptop tidak tertutup benda lunak seperti selimut atau bantal saat digunakan.\n2. Tutup aplikasi berat yang tidak digunakan via Task Manager.\n3. Jika laptop sudah digunakan lebih dari 1 tahun, ajukan tiket perawatan rutin ke IT Helpdesk untuk pembersihan debu dan penggantian thermal paste.",
                'category_id' => $idHardware,
            ],
            [
                'question'    => 'Proyektor ruang meeting tidak mendeteksi tampilan dari laptop',
                'answer'      => "1. Pastikan kabel HDMI/VGA terhubung dengan benar ke port laptop atau konverter Anda.\n2. Di laptop Windows, tekan kombinasi tombol Windows + P lalu pilih opsi 'Duplicate' atau 'Extend'.\n3. Di MacBook, buka System Settings > Displays > pilih Proyektor dan aktifkan 'Mirror for Built-in Display'.",
                'category_id' => $idHardware,
            ],
            [
                'question'    => 'Headset atau mikrofon tidak mengeluarkan suara saat konferensi video',
                'answer'      => "1. Periksa pengaturan Sound Settings Windows, pastikan Output dan Input device sudah mengarah ke Headset Anda.\n2. Periksa tombol mute fisik pada kabel headset.\n3. Di aplikasi Zoom/Teams, buka Audio Settings dan verifikasi perangkat mikrofon yang terpilih.",
                'category_id' => $idHardware,
            ],
            [
                'question'    => 'Scanner kantor menghasilkan gambar bergaris hitam atau buram',
                'answer'      => "1. Buka penutup kaca scanner dan bersihkan permukaan kaca menggunakan kain mikrofiber yang dibasahi sedikit alkohol pembersih.\n2. Pastikan dokumen yang discan tidak memiliki noda tinta basah atau staples yang menggores kaca.\n3. Lakukan kalibrasi scanner melalui software pemindai resmi.",
                'category_id' => $idHardware,
            ],

            // --- SOFTWARE (6 items) ---
            [
                'question'    => 'Aplikasi Microsoft Office meminta aktivasi ulang / Lisensi Expired',
                'answer'      => "Silakan hubungi tim IT Helpdesk atau buat tiket kendala dengan melampirkan hostname PC Anda. Tim IT akan melakukan remote via AnyDesk untuk memasukkan product key perusahaan atau akun Office 365 korporat yang baru.",
                'category_id' => $idSoftware,
            ],
            [
                'question'    => 'Lupa password email kantor atau akun portal internal',
                'answer'      => "1. Gunakan fitur 'Forgot Password' pada halaman login portal untuk menerima link reset via email pribadi terdaftar.\n2. Jika tidak bisa mengakses email, buat tiket ke IT Helpdesk dengan melampirkan persetujuan (approval) dari Manager divisi Anda untuk permohonan reset password manual.",
                'category_id' => $idSoftware,
            ],
            [
                'question'    => 'Komputer mengalami Blue Screen of Death (BSOD) secara berulang',
                'answer'      => "1. Catat kode error BSOD yang muncul di layar (misal: CRITICAL_PROCESS_DIED atau MEMORY_MANAGEMENT).\n2. Restart komputer dalam Safe Mode.\n3. Uninstall update Windows atau driver terakhir yang baru dipasang.\n4. Segera buat tiket ke IT Helpdesk agar dilakukan pengecekan mendalam.",
                'category_id' => $idSoftware,
            ],
            [
                'question'    => 'Bagaimana cara mengajukan instalasi software khusus desain / analisis data?',
                'answer'      => "1. Buat tiket baru pada kategori 'Software'.\n2. Jelaskan nama software beserta spesifikasi versi yang dibutuhkan.\n3. Lampirkan bukti persetujuan dari atasan atau dokumen lisensi departemen.\n4. Tim IT akan melakukan proses deploy software secara remote.",
                'category_id' => $idSoftware,
            ],
            [
                'question'    => 'Browser sangat lambat dan sering muncul pop-up iklan mencurigakan',
                'answer'      => "1. Buka menu Extensions/Add-ons pada browser Anda dan hapus ekstensi asing yang tidak dikenali.\n2. Reset pengaturan browser ke Default Settings.\n3. Jalankan pemindaian penuh (Full Scan) menggunakan Windows Security atau antivirus kantor untuk membersihkan adware/malware.",
                'category_id' => $idSoftware,
            ],
            [
                'question'    => 'File PDF tidak bisa dibuka atau selalu terbuka di browser browser edge',
                'answer'      => "1. Klik kanan pada sembarang file PDF > pilih 'Open with' > klik 'Choose another app'.\n2. Pilih aplikasi Adobe Acrobat Reader atau Foxit PDF.\n3. Centang kotak 'Always use this app to open .pdf files' lalu klik OK.",
                'category_id' => $idSoftware,
            ],
        ];

        foreach ($faqs as $faq) {
            KnowledgeBase::create([
                'question'    => $faq['question'],
                'answer'      => $faq['answer'],
                'category_id' => $faq['category_id'],
                'is_active'   => true,
            ]);
        }
    }
}
