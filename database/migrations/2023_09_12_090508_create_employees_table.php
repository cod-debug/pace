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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->foreignId('office_id')->references('id')->on('office');
            $table->string('employment_status');
            $table->date('birth_date');
            $table->string('civil_status');
            $table->string('home_address');
            $table->string('contact_number');
            $table->string('email_address')->nullable();
            $table->string('facebook_account')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
