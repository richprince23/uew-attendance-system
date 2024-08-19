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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('school')->default('University of Education, Winneba');
            $table->string('app_name')->default('Biometric Attendance System');
            $table->string('address')->default('Winneba, Ghana');
            $table->year('academic_year')->default(2024);
            $table->string('semester')->nullable();
            $table->date('semester_start')->nullable();
            $table->date('semester_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
