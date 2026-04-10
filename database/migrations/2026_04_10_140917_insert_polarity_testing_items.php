<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::select("INSERT INTO polarity_testing_items (name, `key`, section, created_at, updated_at) VALUES
            -- LEFT SIDE
            ('Consumers mains', 'consumers_mains', 'left', NOW(), NOW()),
            ('Circuit protection (circuit breakers / fuses)', 'circuit_protection', 'left', NOW(), NOW()),
            ('RCDs (Safety switches)', 'rcds_safety_switches', 'left', NOW(), NOW()),
            ('Dishwasher', 'dishwasher', 'left', NOW(), NOW()),
            ('Solar and other renewable systems', 'solar_and_other_renewable_systems', 'left', NOW(), NOW()),
            ('Swimming pool equipment', 'swimming_pool_equipment', 'left', NOW(), NOW()),

            -- RIGHT SIDE
            ('Electric water heater', 'electric_water_heater', 'right', NOW(), NOW()),
            ('Air conditioners', 'air_conditioners', 'right', NOW(), NOW()),
            ('Cooking equipment', 'cooking_equipment', 'right', NOW(), NOW()),
            ('Light fittings', 'light_fittings', 'right', NOW(), NOW()),
            ('Socket-outlets', 'socket_outlets', 'right', NOW(), NOW()),
            ('Vehicle chargers', 'vehicle_chargers', 'right', NOW(), NOW())");
    }

    public function down(): void {}
};
