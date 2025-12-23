<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DormitoryRecord extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id', 'hoc_ky_id', 'room_id', 'bed_id',
        'card_number', 'check_in_date', 'check_out_date',
        'reason_leave', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class, 'bed_id');
    }

    public function hocKy()
    {
        return $this->belongsTo(HocKy::class, 'hoc_ky_id');
    }
    public function profile()
{
    return $this->hasOne(PersonalProfile::class, 'user_id', 'user_id');
}
}
