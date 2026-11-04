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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('abn')->nullable();
            $table->string('rec_number')->nullable();
            $table->string('address')->nullable();
            $table->string('service_area')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('electrician_name')->nullable();
            $table->string('insurance_line')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_bsb')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('payment_reference_note')->nullable();

            $table->string('logo_path')->nullable();
            $table->string('logo_dark_path')->nullable();
            $table->string('favicon_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
