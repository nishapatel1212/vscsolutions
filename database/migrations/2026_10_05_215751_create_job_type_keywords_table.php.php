<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_type_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->unique();   // e.g. "downlight"
            $table->string('job_type');             // e.g. "downlight" (the bucket/category)
            $table->string('category')->nullable(); // domestic / commercial / industrial / safety
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('job_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_type_keywords');
    }
};
