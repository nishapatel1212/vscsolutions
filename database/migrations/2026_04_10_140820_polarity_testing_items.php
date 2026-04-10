<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polarity_testing_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->string('section')->nullable();
            $table->timestamps();
        });

        Schema::create('report_polarity_testing_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('safety_check_reports')->cascadeOnDelete();
            $table->foreignId('polarity_testing_item_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_polarity_testing_items');
        Schema::dropIfExists('polarity_testing_items');
    }
};
