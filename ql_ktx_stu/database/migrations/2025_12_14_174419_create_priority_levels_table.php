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
    Schema::create('priority_levels', function (Blueprint $table) {
        $table->id();
        $table->string('name');                    // tên diện ưu tiên
        $table->text('description')->nullable();   // mô tả
        $table->integer('score')->default(0);      // điểm ưu tiên (dùng để xếp phòng)
        $table->boolean('active')->default(true);  // còn hiệu lực không
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priority_levels');
    }
};
