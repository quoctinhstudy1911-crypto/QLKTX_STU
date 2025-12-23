<?php

namespace App\Observers;

use App\Models\DormitoryRecord;
use App\Traits\ActivityLogger;

class DormitoryRecordObserver
{
    use ActivityLogger;

    public function created(DormitoryRecord $record): void
    {
        $studentCode = $record->user?->profile?->student_code ?? 'Unknown';

        $this->logActivity(
            'created',
            "Thêm sinh viên {$studentCode} vào phòng {$record->room?->room_number}, giường {$record->bed?->bed_code}"
        );
    }

    public function updated(DormitoryRecord $record): void
    {
        $studentCode = $record->user?->profile?->student_code ?? 'Unknown';

        if ($record->isDirty('is_active') && !$record->is_active) {
            $description = "Trả phòng sinh viên {$studentCode}";
        } elseif ($record->isDirty('room_id') || $record->isDirty('bed_id')) {
            $description = "Chuyển sinh viên {$studentCode} sang phòng {$record->room?->room_number}, giường {$record->bed?->bed_code}";
        } elseif ($record->isDirty('check_out_date')) {
            $description = "Gia hạn lưu trú sinh viên {$studentCode} đến {$record->check_out_date}";
        } else {
            $description = "Cập nhật lưu trú sinh viên {$studentCode}";
        }

        $this->logActivity(
            'updated',
            $description
        );
    }

    public function deleted(DormitoryRecord $record): void
    {
        $studentCode = $record->user?->profile?->student_code ?? 'Unknown';

        $this->logActivity(
            'deleted',
            "Xóa lưu trú sinh viên {$studentCode}"
        );
    }
}
