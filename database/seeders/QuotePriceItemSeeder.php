<?php

namespace Database\Seeders;

use App\Models\QuotePriceItem;
use Illuminate\Database\Seeder;

class QuotePriceItemSeeder extends Seeder
{
    /**
     * Seeds the price list that used to be hardcoded in python-scripts/quote_ai.py.
     * It now lives in this table instead, editable from the Settings page.
     */
    public function run(): void
    {
        $items = [
            // ---------- DOMESTIC / RESIDENTIAL ----------
            ['keyword' => 'rewire', 'description' => 'Rewire house (per room)', 'amount' => 4500, 'category' => 'domestic'],
            ['keyword' => 'switchboard', 'description' => 'Upgrade switchboard', 'amount' => 900, 'category' => 'domestic'],
            ['keyword' => 'downlight', 'description' => 'Install downlight', 'amount' => 125, 'category' => 'domestic'],
            ['keyword' => 'powerpoint', 'description' => 'Install powerpoint (GPO)', 'amount' => 150, 'category' => 'domestic'],
            ['keyword' => 'light fitting', 'description' => 'Install light fitting', 'amount' => 120, 'category' => 'domestic'],
            ['keyword' => 'ceiling fan', 'description' => 'Install ceiling fan', 'amount' => 220, 'category' => 'domestic'],
            ['keyword' => 'smoke alarm', 'description' => 'Install smoke alarm (interconnected)', 'amount' => 180, 'category' => 'domestic'],
            ['keyword' => 'safety switch', 'description' => 'Install safety switch (RCD)', 'amount' => 220, 'category' => 'domestic'],
            ['keyword' => 'ev charger', 'description' => 'Install home EV charging station', 'amount' => 1800, 'category' => 'domestic'],
            ['keyword' => 'hot water system', 'description' => 'Wire electric hot water system', 'amount' => 350, 'category' => 'domestic'],
            ['keyword' => 'oven', 'description' => 'Install/hardwire electric oven', 'amount' => 200, 'category' => 'domestic'],
            ['keyword' => 'ceiling exhaust fan', 'description' => 'Install bathroom exhaust fan', 'amount' => 250, 'category' => 'domestic'],
            ['keyword' => 'doorbell', 'description' => 'Install/wire doorbell', 'amount' => 100, 'category' => 'domestic'],
            ['keyword' => 'solar', 'description' => 'Solar panel system installation', 'amount' => 6500, 'category' => 'domestic'],
            ['keyword' => 'battery', 'description' => 'Home battery storage installation', 'amount' => 9500, 'category' => 'domestic'],
            ['keyword' => 'outdoor lighting', 'description' => 'Install outdoor/garden lighting', 'amount' => 300, 'category' => 'domestic'],
            ['keyword' => 'security light', 'description' => 'Install sensor security light', 'amount' => 180, 'category' => 'domestic'],
            ['keyword' => 'intercom', 'description' => 'Install intercom system', 'amount' => 400, 'category' => 'domestic'],
            ['keyword' => 'data point', 'description' => 'Install data/network point', 'amount' => 130, 'category' => 'domestic'],
            ['keyword' => 'antenna', 'description' => 'Install TV antenna point', 'amount' => 150, 'category' => 'domestic'],
            ['keyword' => 'extension lead point', 'description' => 'Add new circuit for appliance', 'amount' => 280, 'category' => 'domestic'],

            // ---------- SAFETY / COMPLIANCE ----------
            ['keyword' => 'safety inspection', 'description' => 'Electrical safety inspection', 'amount' => 250, 'category' => 'safety'],
            ['keyword' => 'compliance certificate', 'description' => 'Certificate of Electrical Safety (CES)', 'amount' => 150, 'category' => 'safety'],
            ['keyword' => 'test and tag', 'description' => 'Test and tag appliances (per item)', 'amount' => 8, 'category' => 'safety'],
            ['keyword' => 'thermal imaging', 'description' => 'Thermal imaging scan (switchboard)', 'amount' => 350, 'category' => 'safety'],
            ['keyword' => 'fault finding', 'description' => 'Electrical fault finding/diagnosis', 'amount' => 180, 'category' => 'safety'],
            ['keyword' => 'emergency callout', 'description' => '24/7 emergency callout fee', 'amount' => 220, 'category' => 'safety'],

            // ---------- COMMERCIAL ----------
            ['keyword' => 'commercial fitout', 'description' => 'Commercial electrical fit-out (per sqm)', 'amount' => 85, 'category' => 'commercial'],
            ['keyword' => 'office lighting', 'description' => 'Commercial office lighting installation', 'amount' => 220, 'category' => 'commercial'],
            ['keyword' => 'exit lighting', 'description' => 'Emergency/exit light installation', 'amount' => 250, 'category' => 'commercial'],
            ['keyword' => 'commercial switchboard', 'description' => 'Commercial switchboard upgrade', 'amount' => 3500, 'category' => 'commercial'],
            ['keyword' => '3 phase power', 'description' => 'Install 3-phase power connection', 'amount' => 2800, 'category' => 'commercial'],
            ['keyword' => 'data cabling', 'description' => 'Commercial data/network cabling', 'amount' => 180, 'category' => 'commercial'],
            ['keyword' => 'shop fitout', 'description' => 'Retail shop electrical fit-out', 'amount' => 5500, 'category' => 'commercial'],
            ['keyword' => 'signage wiring', 'description' => 'Commercial signage wiring/lighting', 'amount' => 450, 'category' => 'commercial'],
            ['keyword' => 'hvac wiring', 'description' => 'Wire HVAC/air conditioning unit', 'amount' => 600, 'category' => 'commercial'],
            ['keyword' => 'kitchen wiring', 'description' => 'Commercial kitchen electrical wiring', 'amount' => 2200, 'category' => 'commercial'],
            ['keyword' => 'cctv', 'description' => 'Install CCTV system', 'amount' => 1200, 'category' => 'commercial'],
            ['keyword' => 'access control', 'description' => 'Install access control/security system', 'amount' => 1500, 'category' => 'commercial'],
            ['keyword' => 'generator', 'description' => 'Backup generator installation', 'amount' => 4500, 'category' => 'commercial'],

            // ---------- INDUSTRIAL ----------
            ['keyword' => 'industrial switchboard', 'description' => 'Industrial switchboard installation', 'amount' => 8500, 'category' => 'industrial'],
            ['keyword' => 'motor control', 'description' => 'Motor control circuit installation', 'amount' => 1800, 'category' => 'industrial'],
            ['keyword' => 'machinery wiring', 'description' => 'Industrial machinery wiring/connection', 'amount' => 2500, 'category' => 'industrial'],
            ['keyword' => 'high voltage', 'description' => 'High voltage installation/connection', 'amount' => 15000, 'category' => 'industrial'],
            ['keyword' => 'transformer', 'description' => 'Transformer installation', 'amount' => 12000, 'category' => 'industrial'],
            ['keyword' => 'plc', 'description' => 'PLC/control system wiring', 'amount' => 3200, 'category' => 'industrial'],
            ['keyword' => 'factory lighting', 'description' => 'Industrial/warehouse lighting upgrade', 'amount' => 6500, 'category' => 'industrial'],
            ['keyword' => 'conduit run', 'description' => 'Industrial conduit installation (per meter)', 'amount' => 45, 'category' => 'industrial'],
            ['keyword' => 'cable tray', 'description' => 'Install cable tray system (per meter)', 'amount' => 60, 'category' => 'industrial'],
            ['keyword' => 'earthing system', 'description' => 'Industrial earthing/grounding system', 'amount' => 3500, 'category' => 'industrial'],
        ];

        foreach ($items as $item) {
            QuotePriceItem::firstOrCreate(['keyword' => $item['keyword']], $item);
        }
    }
}
