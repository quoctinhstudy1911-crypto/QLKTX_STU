<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dormitory_records', function (Blueprint $table) {
           $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('hoc_ky_id')
                ->constrained('hoc_kys');

            $table->foreignId('room_id')
                ->constrained('rooms');

            $table->foreignId('bed_id')
                ->constrained('beds');

            $table->string('card_number', 50)->nullable();
            $table->date('check_in_date');
            $table->date('check_out_date')->nullable();
            $table->text('reason_leave')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // RÀNG BUỘC NGHIỆP VỤ
            $table->unique(['user_id', 'hoc_ky_id']); // 1 SV / 1 kỳ
            $table->unique(['bed_id', 'hoc_ky_id']);  // 1 giường / 1 kỳ
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dormitory_records');
    }
};
