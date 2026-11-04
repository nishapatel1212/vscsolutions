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
        Schema::create('quote_price_items', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->unique();   // e.g. "downlight" — matched against job descriptions
            $table->string('description');          // e.g. "Install downlight"
            $table->decimal('amount', 10, 2);
            $table->string('category')->nullable(); // domestic / safety / commercial / industrial
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_price_items');
    }
};
