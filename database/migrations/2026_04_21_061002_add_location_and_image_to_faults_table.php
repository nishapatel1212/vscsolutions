<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('faults', function (Blueprint $table) {
            $table->string('location')->nullable()->after('fault');
            $table->string('image')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faults', function (Blueprint $table) {
            $table->dropColumn(['location', 'image']);
        });
    }
};
