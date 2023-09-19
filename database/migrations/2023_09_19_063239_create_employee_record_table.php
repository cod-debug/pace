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
        Schema::create('employee_record', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->foreignId('employee_id')->references('id')->on('employees');
            $table->string('name');
            $table->string('relationship');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_record');
    }
};
