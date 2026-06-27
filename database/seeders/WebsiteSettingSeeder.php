<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebsiteSetting::set('app_name', 'MariDesk AI');
        WebsiteSetting::set('company_name', 'PT MariDesk Corporate Technology');
        WebsiteSetting::set('support_email', 'helpdesk@example.com');
    }
}
