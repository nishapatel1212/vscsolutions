<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Seeds the single company_settings row for this deployment (Latin Electrical).
     *
     * For a new client, don't edit this file — leave the row empty and fill
     * it in via Settings > Company Profile after first login instead.
     */
    public function run(): void
    {
        if (CompanySetting::query()->exists()) {
            return;
        }

        CompanySetting::create([
            'company_name' => 'Latin Electrical',
            'abn' => '84 786 819 42',
            'rec_number' => '37241',
            'address' => 'Officer, VIC 3809',
            'service_area' => 'Officer, Berwick, Pakenham, Cranbourne, Beaconsfield, Narre Warren, Hallam, Lynbrook and surrounding south-east Melbourne suburbs',
            'email' => 'info@latinelectrical.com.au',
            'phone' => '+61 410 285 075 or +61 422 221 164',
            'electrician_name' => 'Nisha Patel',
            'insurance_line' => 'Insured for $20M public liability (NECA member).',
            'bank_name' => 'Commonwealth Bank',
            'bank_account_name' => 'Jasmeen Patel',
            'bank_bsb' => '063619',
            'bank_account_number' => '11406566',
            'payment_reference_note' => 'USE QUOTE NUMBER AS A REFERENCE.',
            'logo_path' => 'images/logo/latin_logo.png',
            'logo_dark_path' => 'images/logo/latin_logo_dark.png',
            'favicon_path' => 'images/logo/favicon-32x32.png',
        ]);
    }
}
