<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visual_inspection_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // e.g. Consumers mains
            $table->string('key')->unique(); // e.g. consumers_mains
            $table->string('section')->nullable(); // left / right
            $table->timestamps();
        });

        Schema::create('report_visual_inspection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('safety_check_reports')->cascadeOnDelete();
            $table->foreignId('visual_inspection_item_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_visual_inspection_items');
        Schema::dropIfExists('visual_inspection_items');
    }
};
