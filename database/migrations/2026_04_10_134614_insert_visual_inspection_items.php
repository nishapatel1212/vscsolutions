<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::select("INSERT INTO visual_inspection_items (name, `key`, section, created_at, updated_at) VALUES
            -- LEFT SIDE
            ('Consumers mains', 'consumers_mains', 'left', NOW(), NOW()),
            ('Switchboards', 'switchboards', 'left', NOW(), NOW()),
            ('Exposed earth electrode', 'exposed_earth_electrode', 'left', NOW(), NOW()),
            ('Metallic water pipe bond', 'metallic_water_pipe_bond', 'left', NOW(), NOW()),
            ('RCDs (Safety switches)', 'rcds_safety_switches', 'left', NOW(), NOW()),
            ('Circuit protection (circuit breakers / fuses)', 'circuit_protection', 'left', NOW(), NOW()),
            ('Socket-outlets', 'socket_outlets', 'left', NOW(), NOW()),
            ('Light fittings', 'light_fittings', 'left', NOW(), NOW()),
            ('Electric water heater', 'electric_water_heater', 'left', NOW(), NOW()),
            ('Air conditioners', 'air_conditioners', 'left', NOW(), NOW()),

            -- RIGHT SIDE
            ('Space heaters', 'space_heaters', 'right', NOW(), NOW()),
            ('Cooking equipment', 'cooking_equipment', 'right', NOW(), NOW()),
            ('Dishwasher', 'dishwasher', 'right', NOW(), NOW()),
            ('Exhaust fans', 'exhaust_fans', 'right', NOW(), NOW()),
            ('Ceiling fans', 'ceiling_fans', 'right', NOW(), NOW()),
            ('Washing machine/dryer', 'washing_machine_dryer', 'right', NOW(), NOW()),
            ('Installation wiring', 'installation_wiring', 'right', NOW(), NOW()),
            ('Solar and other renewable systems', 'solar_and_other_renewable_systems', 'right', NOW(), NOW()),
            ('Swimming pool equipment', 'swimming_pool_equipment', 'right', NOW(), NOW()),
            ('Vehicle chargers', 'vehicle_chargers', 'right', NOW(), NOW())");
    }

    public function down(): void
    {
        //
    }
};
