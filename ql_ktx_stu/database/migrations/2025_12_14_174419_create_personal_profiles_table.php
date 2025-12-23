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
       Schema::create('personal_profiles', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->unique()
            ->constrained('users')
            ->cascadeOnDelete();

        $table->string('full_name');
        $table->string('student_code', 50)->unique();
        $table->date('dob')->nullable();
        $table->string('gender', 10)->nullable();
        $table->string('phone', 20)->nullable();
        $table->text('address')->nullable();
        $table->string('hometown')->nullable();

        $table->string('citizen_id', 20)
            ->nullable()
            ->unique();

        $table->integer('year_admission')->nullable();
        $table->string('class_name', 100)->nullable();
        $table->string('department', 100)->nullable();
        $table->string('avatar', 255)->nullable();

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_profiles');
    }
};
