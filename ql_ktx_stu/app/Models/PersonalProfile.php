<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Genderable;

class PersonalProfile extends Model
{
    use Genderable;
    protected $fillable = [
        'user_id', 'full_name', 'student_code', 'dob', 'gender',
        'phone', 'address', 'hometown', 'citizen_id',
        'priority_type', 'year_admission', 'class_name', 'department', 'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     /**
     * Quan hệ logic (không FK DB)
     * Đối chiếu sinh viên chính thức theo mã sinh viên
     */
    
    public function studentOfficial()
    {
        return $this->hasOne(StudentOfficial::class, 'student_code', 'student_code');
    }

}
