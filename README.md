<div align="center">
  <img src="public/assets/images/logo.png" alt="MariDesk AI Logo" width="120" style="border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
  
  # 🚀 MariDesk AI
  ### Sistem Manajemen IT Helpdesk & Asisten Virtual Cerdas Berbasis AI
  
  [![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![Flowbite](https://img.shields.io/badge/Flowbite-UI_Library-1E40AF?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://flowbite.com)
  [![PHP Version](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
  [![AI Powered](https://img.shields.io/badge/AI_Powered-OpenAI_%2F_Gemini-412991?style=for-the-badge&logo=openai&logoColor=white)](https://openai.com)
</div>

---

## 🌟 Tentang Proyek (Portfolio Highlight)

**MariDesk AI** adalah solusi platform **IT Helpdesk modern** yang digabungkan dengan **Kecerdasan Buatan (AI Chatbot)** untuk mentransformasi cara perusahaan menangani kendala teknis sehari-hari. 

Proyek ini dibangun sebagai representasi nyata dari alur kerja operasional IT Support di level *enterprise*, di mana efisiensi, kecepatan respon, dan kepuasan pengguna menjadi prioritas utama. Dengan menyaring pertanyaan umum melalui *Knowledge Base* pintar, MariDesk AI menghemat hingga **70% waktu teknisi IT**, sehingga teknisi dapat fokus menyelesaikan masalah teknis yang lebih kompleks.

---

## ✨ Fitur Unggulan

### 🛡️ 1. Arsitektur Multi-Role Enterprise (4 Peran)
* **Pemisahan Hak Akses Spesifik**:
  * `Admin`: Pusat kontrol sistem (konfigurasi AI, kelola user, knowledge base, laporan menyeluruh).
  * `Service Desk`: Penerima awal tiket kendala yang bertugas memvalidasi dan mendistribusikan (*assign*) tiket kepada teknisi.
  * `Helpdesk`: Teknisi spesialis penanggung jawab eksekusi penanganan kendala teknis.
  * `User`: Karyawan/Pelapor yang mengajukan tiket dan memantau status penyelesaian.

### 🤖 2. AI Chatbot, Takeover & Ruang Diskusi Realtime (Laravel Reverb)
* **Komunikasi Realtime WebSocket**: Ruang diskusi obrolan tiket terintegrasi secara *realtime* menggunakan **Laravel Reverb** (tanpa perlu layanan pihak ketiga). Pesan baru dan balasan bot AI muncul seketika di layar semua partisipan.
* **Automasi Jawaban Instan**: AI menjawab kendala pelapor 24/7 berdasarkan *Knowledge Base*.
* **AI Takeover (Smart Pause)**: Begitu teknisi Helpdesk membalas pesan di ruang obrolan, bot AI otomatis dijeda (*Takeover*) agar tidak berbenturan dengan instruksi teknisi, dilengkapi tombol sakelar aktif/nonaktif manual.
* **AI Suggested Reply (*Standout Feature*)**: Tombol pintar yang merumuskan draf rekomendasi jawaban solutif dan profesional bagi teknisi dalam satu klik, mempercepat waktu penanganan tiket (*SLA*).

### 🎫 3. Manajemen Tiket & Penugasan Teknisi
* **Dasbor Analisis & Filter Waktu**: Pemantauan KPI layanan IT secara real-time dengan filter rentang waktu (*Hari Ini, 7 Hari, 30 Hari, Bulan Ini, atau Kustom*).
* **Alur Status Transparan**: Tiket baru secara default berstatus `Open` dan `Unassigned`. Service Desk dapat menugaskannya langsung ke Helpdesk yang relevan (`Open` ➔ `Progress` ➔ `Closed`).
* **Kategori & Prioritas**: Pengelompokan *Hardware*, *Software*, *Network* dengan indikator urgensi (*Low*, *Medium*, *High*, *Urgent*).

### 📊 4. Analisis Sentimen AI & Statistik Kinerja Helpdesk
* **Deteksi Emosi Pelapor**: AI otomatis memindai nada pesan saat tiket dibuat (**😊 Puas / 😐 Netral / 😠 Tidak Puas / Urgent**).
* **Statistik Evaluasi Helpdesk**: Rekapitulasi performa harian, mingguan, bulanan, serta rasio tiket aktif vs selesai untuk setiap teknisi sebagai acuan evaluasi KPI tim.

### ⚙️ 5. Konfigurasi AI Provider & Manajemen Profil Dinamis
* **Fleksibilitas Provider AI**: Admin dapat memilih dan mengganti penyedia layanan AI (**OpenRouter, OpenAI, Google Gemini, atau Custom Base URL**) serta mengubah identifier model langsung dari Dasbor UI tanpa mengedit `.env`.
* **Manajemen Profil & Keamanan**: Pengguna dapat mengelola informasi akun, memperbarui kontak, serta mengganti kata sandi secara aman.

### 🎨 6. Desain UI/UX Premium & Mode Gelap (*Dark Mode*)
* Didesain dengan **Tailwind CSS v4.0** dan **Flowbite**, memberikan tampilan yang estetis, *glassmorphism*, bergaya *modern dynamic*, serta **100% responsif** di semua perangkat (Desktop, Tablet, dan Mobile).
* Dilengkapi dengan efek interaktif, transisi halus, dan kursor kustom.

### 🇮🇩 7. Lokalisasi Indonesia Penuh
* Menggunakan format waktu **Carbon Indonesia (`translatedFormat`)** dengan jam, menit, dan detik (WIB).
* Sudah dilengkapi 20+ seeder data *Knowledge Base* kasus nyata IT Helpdesk kantor di Indonesia.

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi / Library |
| :--- | :--- |
| **Backend Framework** | Laravel 12 (PHP 8.2+) |
| **Frontend Styling** | Tailwind CSS v4.0, Vanilla CSS |
| **Component Library** | Flowbite Components & Flowbite SVG Icons |
| Komponen | Teknologi / Library |
| :--- | :--- |
| **Backend Framework** | Laravel 12 (PHP 8.2+) |
| **Realtime WebSocket** | Laravel Reverb & Laravel Echo |
| **Frontend Styling** | Tailwind CSS v4.0, Vanilla CSS |
| **Component Library** | Flowbite UI Components & Flowbite SVG Icons |
| **Interactive Tables** | Flowbite DataTables (`simple-datatables`) |
| **Database** | MySQL (Laragon / Eloquent ORM) |
| **AI Integration** | OpenAI API / Gemini API / OpenRouter LLM |
| **PDF & Excel Export** | DomPDF & Maatwebsite Excel |
| **Notification & Alert** | Flowbite Toast / SweetAlert2 |

---

## 🚀 Panduan Instalasi & Menjalankan Proyek (Local Development)

### 1. Kloning Repositori & Instal Dependensi
```bash
git clone https://github.com/hndko/app_aichatbothelpdesk_laravel12.git
cd app_aichatbothelpdesk_laravel12
composer install
npm install
```

### 2. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`, lalu atur koneksi database dan kredensial AI Anda:
```bash
cp .env.example .env
php artisan key:generate
```
Pastikan konfigurasi AI dan WebSocket Reverb di `.env` sudah diatur:
```env
# AI Provider Configuration
AI_PROVIDER=openai # Pilihan: openai / gemini / openrouter / custom
AI_API_KEY="your-api-key-here"
AI_MODEL="gpt-4o-mini"

# Laravel Reverb WebSocket
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=my-app-id
REVERB_APP_KEY=my-app-key
REVERB_APP_SECRET=my-app-secret
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http
```
> [!TIP]
> **Cara Mengisi Konfigurasi Reverb:** Karena Laravel Reverb bertindak sebagai server WebSocket *self-hosted* lokal, Anda **tidak perlu mendaftar ke layanan pihak ketiga (seperti Pusher)**. Nilai `REVERB_APP_ID`, `REVERB_APP_KEY`, dan `REVERB_APP_SECRET` **bebas Anda buat dengan teks rahasia/angka acak apa saja** (contoh: `REVERB_APP_ID=982341`, `REVERB_APP_KEY=rahasia_key_maridesk`, `REVERB_APP_SECRET=rahasia_secret_maridesk`). Alternatifnya, Anda juga bisa menjalankan perintah `php artisan reverb:install` untuk dibuatkan secara otomatis oleh Laravel.

### 3. Migrasi & Seeding Database
Jalankan migrasi beserta seeder terpecah yang menyediakan 20+ FAQ dan akun demo multi-role:
```bash
php artisan migrate:fresh --seed
```

### 4. Build Asset & Menjalankan Server Realtime
Untuk menjalankan aplikasi dengan dukungan penuh fitur obrolan realtime (*WebSocket*) dan tabel interaktif, Anda disarankan membuka **3 terminal terpisah**:

**Terminal 1 (Laravel Web Server):**
```bash
php artisan serve
```

**Terminal 2 (Laravel Reverb WebSocket Server):**
```bash
php artisan reverb:start --debug
```

**Terminal 3 (Vite Asset Compiler - Development / Production Build):**
```bash
# Untuk pengembangan lokal:
npm run dev

# ATAU untuk build produksi:
npm run build
```

Buka browser Anda dan akses aplikasi melalui: **`http://127.0.0.1:8000`**

---

## 🌐 Panduan Deployment (Produksi / Server Cloud)

Jika Anda ingin mendeploy aplikasi ini ke VPS (Ubuntu/Debian) atau Shared Hosting, ikuti langkah berikut:

### 1. Persiapan Lingkungan Produksi
Pastikan server memiliki PHP 8.2+, MySQL 8.0+/MariaDB, Nginx/Apache, Composer, dan Node.js.

### 2. Optimasi Laravel & Vite Build
Di server produksi, jalankan perintah optimasi:
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Menjalankan Laravel Reverb di Background (Supervisor)
Agar server WebSocket Reverb tetap berjalan di latar belakang tanpa henti pada lingkungan VPS, gunakan **Supervisor**. Buat file konfigurasi `/etc/supervisor/conf.d/reverb.conf`:
```ini
[program:maridesk-reverb]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/app_aichatbothelpdesk_laravel12/artisan reverb:start
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/path/to/app_aichatbothelpdesk_laravel12/storage/logs/reverb.log
```
Perbarui supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start maridesk-reverb:*
```

### 4. Konfigurasi Proxy Nginx untuk WebSocket
Tambahkan blok lokasi reverse proxy untuk port Reverb (8080) pada konfigurasi Nginx domain Anda:
```nginx
location /app {
    proxy_http_version 1.1;
    proxy_set_header Host $http_host;
    proxy_set_header Scheme $scheme;
    proxy_set_header SERVER_PORT $server_port;
    proxy_set_header REMOTE_ADDR $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection "Upgrade";
    proxy_pass http://0.0.0.0:8080;
}
```

### 5. 💡 Alternatif Deployment di Shared Hosting (cPanel)
Apakah aplikasi ini bisa diinstal di **Shared Hosting biasa (cPanel)**? **Bisa!** Namun ada catatan khusus mengenai layanan WebSocket:
- **Hosting Standar tanpa SSH / Supervisor:** Server Shared Hosting umumnya melarang pembukaan port custom (seperti port `8080` Reverb) atau menjalankan proses latar belakang permanen. Agar fitur obrolan realtime tetap berjalan lancar di cPanel, Anda dapat beralih menggunakan layanan **Pusher Cloud (Layanan Gratis hingga 200k pesan/hari)** dengan mengubah `.env`:
  ```env
  BROADCAST_CONNECTION=pusher
  PUSHER_APP_ID="id-pusher-anda"
  PUSHER_APP_KEY="key-pusher-anda"
  PUSHER_APP_SECRET="secret-pusher-anda"
  PUSHER_HOST=
  PUSHER_PORT=443
  PUSHER_SCHEME=https
  PUSHER_APP_CLUSTER="ap1"
  ```
  *(Atau ubah menjadi `BROADCAST_CONNECTION=log` jika tidak membutuhkan WebSocket realtime).*
- **Cloud Hosting dengan SSH / Cron Watchdog:** Jika cPanel Anda memiliki akses Terminal dan mengizinkan proses background, Anda bisa membuat Cron Job yang berjalan setiap 1 menit untuk memastikan `php artisan reverb:start` tetap aktif.

---

## 🔐 Akun Demo (Untuk Pengujian)

Proyek ini telah menyediakan 5 akun uji coba multi-role yang siap digunakan:

| Peran (*Role*) | Email | Password | Spesialisasi & Hak Akses |
| :--- | :--- | :--- | :--- |
| 🛡️ **Admin IT** | `admin@example.com` | `password` | Kendali penuh sistem, konfigurasi AI LLM, kelola seluruh pengguna & laporan PDF/Excel |
| 📋 **Service Desk** | `servicedesk@example.com` | `password` | Menerima tiket masuk, memvalidasi kendala, dan menugaskan (*assign*) ke teknisi Helpdesk |
| 🔧 **Helpdesk 1** | `helpdesk1@example.com` | `password` | Spesialis **Hardware & Network**. Mengeksekusi penanganan tiket, fitur AI Suggested Reply |
| 💻 **Helpdesk 2** | `helpdesk2@example.com` | `password` | Spesialis **Software**. Mengeksekusi penanganan tiket, interaksi chat realtime dengan pelapor |
| 👤 **Karyawan / User** | `user@example.com` | `password` | Pelapor kendala IT, tanya jawab otomatis dengan AI Chatbot (Takeover siap saji) |
| 👤 **Karyawan 2** | `siti@example.com` | `password` | Pelapor kendala IT |

---

## 📸 Snapshot Struktur Seeder

Proyek ini menerapkan arsitektur *seeder* yang modular dan bersih (`database/seeders/`):
* `CategorySeeder.php` ➔ Data kategori Hardware, Software, Network.
* `UserSeeder.php` ➔ Akun Administrator, Service Desk, Helpdesk Spesialis, & Karyawan.
* `WebsiteSettingSeeder.php` ➔ Konfigurasi nama platform & identitas perusahaan.
* `KnowledgeBaseSeeder.php` ➔ 20+ FAQ realistis IT Helpdesk Indonesia.
* `TicketSeeder.php` ➔ Contoh tiket awal beserta riwayat interaksi.

---

<div align="center">
  <p>Dikembangkan dengan ❤️ sebagai bukti portofolio keahlian pengerjaan aplikasi <strong>AI Agentic Coding & Fullstack Laravel Development</strong>.</p>
</div>
