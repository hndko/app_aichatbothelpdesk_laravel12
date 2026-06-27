<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum role di MySQL
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'service_desk', 'helpdesk', 'user') NOT NULL DEFAULT 'user'");

        Schema::table('tickets', function (Blueprint $table) {
            $table->boolean('is_ai_active')->default(true)->after('sentiment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('is_ai_active');
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
    }
};
