<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payslip_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payslip_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['allowance', 'deduction']);
            $table->string('name');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslip_details');
    }
};
