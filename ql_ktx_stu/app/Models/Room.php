<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Genderable;

class Room extends Model
{
    use Genderable;
    protected $fillable = [
        'room_number', 'gender',
        'capacity', 'area', 'room_type', 'description','floor'
    ];

    public function beds()
    {
        return $this->hasMany(Bed::class, 'room_id');
    }

    public function dormitoryRecords()
    {
        return $this->hasMany(DormitoryRecord::class, 'room_id');
    }

    public function availableBeds()
    {
        return $this->hasMany(Bed::class, 'room_id')->where('status', 'available');
    }
}
