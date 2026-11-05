<?php

namespace Database\Seeders;

use App\Models\JobTypeKeyword;
use Illuminate\Database\Seeder;

class JobTypeKeywordSeeder extends Seeder
{
    public function run(): void
    {
        $keywords = [
            // --- Domestic / Residential ---
            ['keyword' => 'rewire',               'job_type' => 'rewire',            'category' => 'domestic'],
            ['keyword' => 'rewiring',              'job_type' => 'rewire',            'category' => 'domestic'],
            ['keyword' => 'switchboard',           'job_type' => 'switchboard',       'category' => 'domestic'],
            ['keyword' => 'switch board',          'job_type' => 'switchboard',       'category' => 'domestic'],
            ['keyword' => 'fuse box',              'job_type' => 'switchboard',       'category' => 'domestic'],
            ['keyword' => 'downlight',             'job_type' => 'downlight',         'category' => 'domestic'],
            ['keyword' => 'down light',            'job_type' => 'downlight',         'category' => 'domestic'],
            ['keyword' => 'ceiling light',         'job_type' => 'ceiling_light',     'category' => 'domestic'],
            ['keyword' => 'ceilling light',        'job_type' => 'ceiling_light',     'category' => 'domestic'], // matches real typo in DB
            ['keyword' => 'pendant light',         'job_type' => 'ceiling_light',     'category' => 'domestic'],
            ['keyword' => 'light fitting',         'job_type' => 'ceiling_light',     'category' => 'domestic'],
            ['keyword' => 'dimmer switch',         'job_type' => 'lighting_install',  'category' => 'domestic'],
            ['keyword' => 'lighting:',             'job_type' => 'lighting_install',  'category' => 'domestic'],
            ['keyword' => 'indoor lights',         'job_type' => 'lighting_install',  'category' => 'domestic'],
            ['keyword' => 'outdoor lighting',      'job_type' => 'outdoor_lighting',  'category' => 'domestic'],
            ['keyword' => 'garden lighting',       'job_type' => 'outdoor_lighting',  'category' => 'domestic'],
            ['keyword' => 'security light',        'job_type' => 'outdoor_lighting',  'category' => 'domestic'],
            ['keyword' => 'sensor light',          'job_type' => 'outdoor_lighting',  'category' => 'domestic'],
            ['keyword' => 'powerpoint',            'job_type' => 'powerpoint',        'category' => 'domestic'],
            ['keyword' => 'power point',           'job_type' => 'powerpoint',        'category' => 'domestic'],
            ['keyword' => 'gpo',                   'job_type' => 'powerpoint',        'category' => 'domestic'],
            ['keyword' => 'double power point',    'job_type' => 'powerpoint',        'category' => 'domestic'],
            ['keyword' => 'ceiling fan',           'job_type' => 'ceiling_fan',       'category' => 'domestic'],
            ['keyword' => 'exhaust fan',           'job_type' => 'exhaust_fan',       'category' => 'domestic'],
            ['keyword' => 'bathroom fan',          'job_type' => 'exhaust_fan',       'category' => 'domestic'],
            ['keyword' => 'smoke alarm',           'job_type' => 'smoke_alarm',       'category' => 'domestic'],
            ['keyword' => 'smoke detector',        'job_type' => 'smoke_alarm',       'category' => 'domestic'],
            ['keyword' => 'interconnected alarm',  'job_type' => 'smoke_alarm',       'category' => 'domestic'],
            ['keyword' => 'safety switch',         'job_type' => 'safety_switch',     'category' => 'domestic'],
            ['keyword' => 'rcd',                   'job_type' => 'safety_switch',     'category' => 'domestic'],
            ['keyword' => 'circuit breaker',       'job_type' => 'safety_switch',     'category' => 'domestic'],
            ['keyword' => 'ev charger',            'job_type' => 'ev_charger',        'category' => 'domestic'],
            ['keyword' => 'ev charging',           'job_type' => 'ev_charger',        'category' => 'domestic'],
            ['keyword' => 'electric vehicle',      'job_type' => 'ev_charger',        'category' => 'domestic'],
            ['keyword' => 'hot water system',      'job_type' => 'hot_water',         'category' => 'domestic'],
            ['keyword' => 'hot water',             'job_type' => 'hot_water',         'category' => 'domestic'],
            ['keyword' => 'electric oven',         'job_type' => 'oven',              'category' => 'domestic'],
            ['keyword' => 'cooktop',               'job_type' => 'oven',              'category' => 'domestic'],
            ['keyword' => 'doorbell',              'job_type' => 'doorbell',          'category' => 'domestic'],
            ['keyword' => 'intercom',               'job_type' => 'intercom',          'category' => 'domestic'],
            ['keyword' => 'solar panel',           'job_type' => 'solar',             'category' => 'domestic'],
            ['keyword' => 'solar system',          'job_type' => 'solar',             'category' => 'domestic'],
            ['keyword' => 'battery storage',       'job_type' => 'battery',           'category' => 'domestic'],
            ['keyword' => 'home battery',          'job_type' => 'battery',           'category' => 'domestic'],
            ['keyword' => 'data point',            'job_type' => 'data_point',        'category' => 'domestic'],
            ['keyword' => 'network point',         'job_type' => 'data_point',        'category' => 'domestic'],
            ['keyword' => 'tv antenna',            'job_type' => 'antenna',           'category' => 'domestic'],
            ['keyword' => 'antenna point',         'job_type' => 'antenna',           'category' => 'domestic'],
            ['keyword' => 'extension lead',        'job_type' => 'extra_circuit',     'category' => 'domestic'],
            ['keyword' => 'new circuit',           'job_type' => 'extra_circuit',     'category' => 'domestic'],
            ['keyword' => 'garage wiring',         'job_type' => 'extra_circuit',     'category' => 'domestic'],

            // --- Safety / Compliance ---
            ['keyword' => 'safety inspection',     'job_type' => 'safety_inspection', 'category' => 'safety'],
            ['keyword' => 'electrical inspection', 'job_type' => 'safety_inspection', 'category' => 'safety'],
            ['keyword' => 'compliance certificate', 'job_type' => 'compliance_cert',   'category' => 'safety'],
            ['keyword' => 'ces',                   'job_type' => 'compliance_cert',   'category' => 'safety'],
            ['keyword' => 'test and tag',          'job_type' => 'test_and_tag',      'category' => 'safety'],
            ['keyword' => 'tag testing',           'job_type' => 'test_and_tag',      'category' => 'safety'],
            ['keyword' => 'thermal imaging',       'job_type' => 'thermal_imaging',   'category' => 'safety'],
            ['keyword' => 'thermal scan',          'job_type' => 'thermal_imaging',   'category' => 'safety'],
            ['keyword' => 'fault finding',         'job_type' => 'fault_finding',     'category' => 'safety'],
            ['keyword' => 'fault diagnosis',       'job_type' => 'fault_finding',     'category' => 'safety'],
            ['keyword' => 'troubleshoot',          'job_type' => 'fault_finding',     'category' => 'safety'],
            ['keyword' => 'emergency callout',     'job_type' => 'emergency_callout', 'category' => 'safety'],
            ['keyword' => 'after hours',           'job_type' => 'emergency_callout', 'category' => 'safety'],
            ['keyword' => '24/7',                  'job_type' => 'emergency_callout', 'category' => 'safety'],

            // --- Commercial ---
            ['keyword' => 'commercial fitout',     'job_type' => 'commercial_fitout', 'category' => 'commercial'],
            ['keyword' => 'office fitout',         'job_type' => 'commercial_fitout', 'category' => 'commercial'],
            ['keyword' => 'office lighting',       'job_type' => 'office_lighting',   'category' => 'commercial'],
            ['keyword' => 'exit light',            'job_type' => 'exit_lighting',     'category' => 'commercial'],
            ['keyword' => 'emergency light',       'job_type' => 'exit_lighting',     'category' => 'commercial'],
            ['keyword' => 'commercial switchboard', 'job_type' => 'commercial_switchboard', 'category' => 'commercial'],
            ['keyword' => '3 phase power',         'job_type' => 'three_phase',       'category' => 'commercial'],
            ['keyword' => 'three phase',           'job_type' => 'three_phase',       'category' => 'commercial'],
            ['keyword' => 'data cabling',          'job_type' => 'data_cabling',      'category' => 'commercial'],
            ['keyword' => 'network cabling',       'job_type' => 'data_cabling',      'category' => 'commercial'],
            ['keyword' => 'shop fitout',           'job_type' => 'shop_fitout',       'category' => 'commercial'],
            ['keyword' => 'retail fitout',         'job_type' => 'shop_fitout',       'category' => 'commercial'],
            ['keyword' => 'signage wiring',        'job_type' => 'signage',           'category' => 'commercial'],
            ['keyword' => 'shop sign',             'job_type' => 'signage',           'category' => 'commercial'],
            ['keyword' => 'hvac wiring',           'job_type' => 'hvac',              'category' => 'commercial'],
            ['keyword' => 'air conditioning',      'job_type' => 'hvac',              'category' => 'commercial'],
            ['keyword' => 'commercial kitchen',    'job_type' => 'commercial_kitchen', 'category' => 'commercial'],
            ['keyword' => 'cctv',                  'job_type' => 'cctv',              'category' => 'commercial'],
            ['keyword' => 'security camera',       'job_type' => 'cctv',              'category' => 'commercial'],
            ['keyword' => 'access control',        'job_type' => 'access_control',    'category' => 'commercial'],
            ['keyword' => 'swipe card',            'job_type' => 'access_control',    'category' => 'commercial'],
            ['keyword' => 'generator',             'job_type' => 'generator',         'category' => 'commercial'],
            ['keyword' => 'backup power',          'job_type' => 'generator',         'category' => 'commercial'],

            // --- Industrial ---
            ['keyword' => 'industrial switchboard', 'job_type' => 'industrial_switchboard', 'category' => 'industrial'],
            ['keyword' => 'motor control',         'job_type' => 'motor_control',     'category' => 'industrial'],
            ['keyword' => 'machinery wiring',      'job_type' => 'machinery_wiring',  'category' => 'industrial'],
            ['keyword' => 'high voltage',          'job_type' => 'high_voltage',      'category' => 'industrial'],
            ['keyword' => 'transformer',           'job_type' => 'transformer',       'category' => 'industrial'],
            ['keyword' => 'plc',                   'job_type' => 'plc',               'category' => 'industrial'],
            ['keyword' => 'control system',        'job_type' => 'plc',               'category' => 'industrial'],
            ['keyword' => 'factory lighting',      'job_type' => 'factory_lighting',  'category' => 'industrial'],
            ['keyword' => 'warehouse lighting',    'job_type' => 'factory_lighting',  'category' => 'industrial'],
            ['keyword' => 'conduit',               'job_type' => 'conduit_run',       'category' => 'industrial'],
            ['keyword' => 'cable tray',            'job_type' => 'cable_tray',        'category' => 'industrial'],
            ['keyword' => 'earthing system',       'job_type' => 'earthing',          'category' => 'industrial'],
            ['keyword' => 'grounding',             'job_type' => 'earthing',          'category' => 'industrial'],
        ];

        foreach ($keywords as $row) {
            JobTypeKeyword::updateOrCreate(
                ['keyword' => $row['keyword']],
                $row
            );
        }

        $this->command->info('Seeded ' . count($keywords) . ' job type keywords.');
    }
}
