<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::select("INSERT INTO earth_testing_items (name, `key`, section, created_at, updated_at) VALUES
            -- LEFT SIDE
            ('Mains earth conductor', 'mains_earth_conductor', 'left', NOW(), NOW()),
            ('Switchboards enclosure', 'switchboards_enclosure', 'left', NOW(), NOW()),
            ('Metallic water pipe bond', 'metallic_water_pipe_bond', 'left', NOW(), NOW()),
            ('Socket-outlets', 'socket_outlets', 'left', NOW(), NOW()),
            ('Light fittings', 'light_fittings', 'left', NOW(), NOW()),
            ('Exhaust fans', 'exhaust_fans', 'left', NOW(), NOW()),
            ('Ceiling fans', 'ceiling_fans', 'left', NOW(), NOW()),

            -- RIGHT SIDE
            ('Electric water heater', 'electric_water_heater', 'right', NOW(), NOW()),
            ('Air conditioners', 'air_conditioners', 'right', NOW(), NOW()),
            ('Cooking equipment', 'cooking_equipment', 'right', NOW(), NOW()),
            ('Dishwasher', 'dishwasher', 'right', NOW(), NOW()),
            ('Solar and other renewable systems', 'solar_and_other_renewable_systems', 'right', NOW(), NOW()),
            ('Swimming pool equipment', 'swimming_pool_equipment', 'right', NOW(), NOW()),
            ('Vehicle chargers', 'vehicle_chargers', 'right', NOW(), NOW())");
    }

    public function down(): void {}
};
