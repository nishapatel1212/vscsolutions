<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('report_images', function (Blueprint $table) {
            $table->id();

            // 🔥 Foreign Key
            $table->foreignId('report_id')
                ->constrained('safety_check_reports')
                ->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('image_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_images');
    }
};
