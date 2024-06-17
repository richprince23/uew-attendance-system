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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('surname', 50);
            $table->string('other_names', 50);
            $table->bigInteger('index_number');
            $table->integer('level');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('group')->nullable();
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
