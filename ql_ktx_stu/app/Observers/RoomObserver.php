<?php
namespace App\Observers;

use App\Models\Room;
use App\Models\ActivityLog;

class RoomObserver
{
    public function created(Room $room)
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Room::class,
            'model_id'    => $room->id,
            'action'      => 'created',
            'description' => "Tạo phòng {$room->room_number} ({$room->room_type}), sức chứa {$room->capacity} giường",
            'ip_address'  => request()->ip(),
            'created_at'  => now(),
        ]);
    }

    public function updated(Room $room)
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Room::class,
            'model_id'    => $room->id,
            'action'      => 'updated',
            'description' => "Cập nhật phòng {$room->room_number} ({$room->room_type}), sức chứa {$room->capacity} giường",
            'ip_address'  => request()->ip(),
            'created_at'  => now(),
        ]);
    }

    public function deleted(Room $room)
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Room::class,
            'model_id'    => $room->id,
            'action'      => 'deleted',
            'description' => "Xóa phòng {$room->room_number}",
            'ip_address'  => request()->ip(),
            'created_at'  => now(),
        ]);
    }
}
