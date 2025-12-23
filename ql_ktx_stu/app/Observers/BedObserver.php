<?php

namespace App\Observers;
use App\Models\Bed;
use App\Traits\ActivityLogger;

class BedObserver
{
    use ActivityLogger;

    public function created(Bed $bed): void
    {
        $this->logActivity(
            'created',
            "Thêm mới giường {$bed->bed_code} trong phòng {$bed->room_id}"
        );
    }

    public function updated(Bed $bed): void
    {
        $this->logActivity(
            'updated',
            "Cập nhật giường {$bed->bed_code} trong phòng {$bed->room_id}"
        );
    }

    public function deleted(Bed $bed): void
    {
        $this->logActivity(
            'deleted',
            "Xóa giường {$bed->bed_code} khỏi phòng {$bed->room_id}"
        );
    }
}
