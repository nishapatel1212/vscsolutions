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
        Schema::create('safety_check_reports', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->date('report_date');
            $table->date('previous_safety_date')->nullable();
            $table->string('safety_check_status');
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_check_reports');
    }
};
