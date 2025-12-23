<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $fillable = [
        'room_id', 'bed_code', 'status', 'note'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function dormitoryRecords()
    {
        return $this->hasMany(DormitoryRecord::class, 'bed_id');
    }
}
