<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CompanySettingSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            JobTypeKeywordSeeder::class,
            QuotePriceItemSeeder::class,
            EmailTemplateSeeder::class,
            SmsTemplateSeeder::class,
        ]);
    }
}
