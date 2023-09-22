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
        Schema::create('agency_fee', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->date('payment_date');
            $table->float('union_dues');
            $table->float('ip_funds');
            $table->float('fa');
            $table->string('notes')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_fee');
    }
};
