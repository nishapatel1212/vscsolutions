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
        DB::select("INSERT INTO inspection_items (name, `key`, section, created_at, updated_at) VALUES
            -- LEFT SIDE
            ('Main Switchboard', 'main_switchboard', 'left', NOW(), NOW()),
            ('Main earthing system', 'main_earthing_system', 'left', NOW(), NOW()),
            ('Kitchen', 'kitchen', 'left', NOW(), NOW()),
            ('Bathroom (main)', 'bathroom_main', 'left', NOW(), NOW()),
            ('Other bathrooms/ensuites', 'other_bathrooms_ensuites', 'left', NOW(), NOW()),
            ('Bedroom (main)', 'bedroom_main', 'left', NOW(), NOW()),
            ('Other bedrooms', 'other_bedrooms', 'left', NOW(), NOW()),
            ('Living room', 'living_room', 'left', NOW(), NOW()),

            -- RIGHT SIDE
            ('Other living areas', 'other_living_areas', 'right', NOW(), NOW()),
            ('Laundry', 'laundry', 'right', NOW(), NOW()),
            ('Garage', 'garage', 'right', NOW(), NOW()),
            ('Solar/battery system', 'solar_battery_system', 'right', NOW(), NOW()),
            ('Electric water heater', 'electric_water_heater', 'right', NOW(), NOW()),
            ('Dishwasher', 'dishwasher', 'right', NOW(), NOW()),
            ('Electric room/space heaters', 'electric_room_space_heaters', 'right', NOW(), NOW()),
            ('Swimming pool equipment', 'swimming_pool_equipment', 'right', NOW(), NOW())");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
