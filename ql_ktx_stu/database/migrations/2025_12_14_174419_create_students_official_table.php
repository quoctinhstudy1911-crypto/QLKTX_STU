<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students_official', function (Blueprint $table) {
            $table->id();
            $table->string('student_code', 50)->unique();
            $table->string('full_name');
            $table->string('gender', 10)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('class_name', 100)->nullable();
            $table->string('email', 191)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students_official');
    }
};
