<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->string('room_number', 50)->unique();
        $table->enum('gender', ['male', 'female']);
        $table->unsignedInteger('capacity')->default(10);
        $table->decimal('area', 6, 2)->nullable();
        $table->string('room_type', 100)->nullable();
        $table->text('description')->nullable();
        $table->unsignedInteger('floor')->nullable();
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
