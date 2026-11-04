<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['coes', 'test_and_tag']);
            $table->string('certificate_number')->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('safety_check_report_id')->nullable()->constrained('safety_check_reports')->nullOnDelete();
            $table->string('client_name');
            $table->string('address');
            $table->date('issued_date');
            $table->date('expiry_date')->nullable();
            $table->string('electrician_name')->nullable();
            $table->string('licence_number')->nullable();
            $table->string('status')->default('compliant');
            $table->text('notes')->nullable();
            $table->string('signature_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
