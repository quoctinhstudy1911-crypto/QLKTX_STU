<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('register_requests', function (Blueprint $table) {
                $table->id();

                // Thông tin sinh viên
                $table->string('full_name');
                $table->string('student_code', 50);
                $table->string('gender', 10)->nullable();
                $table->date('dob')->nullable();
                $table->string('phone', 20)->nullable();
                $table->text('address')->nullable();

                // Lý do
                $table->text('reason')->nullable();

                // Ưu tiên
                $table->foreignId('priority_level_id')
                    ->nullable()
                    ->constrained('priority_levels')
                    ->nullOnDelete();

                // Trạng thái
                $table->enum('status', ['pending', 'approved', 'rejected'])
                    ->default('pending');

                // Admin xử lý
                $table->text('note')->nullable();

                $table->foreignId('approved_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->timestamp('approved_at')->nullable();

                // 👉 THÊM rejected NGAY TẠI ĐÂY
                $table->foreignId('rejected_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->timestamp('rejected_at')->nullable();
                $table->text('rejected_reason')->nullable();

                $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('register_requests');
    }
};
