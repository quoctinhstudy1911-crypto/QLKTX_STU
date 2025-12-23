<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DormitoryRecord;
use App\Traits\Genderable;

class RegisterRequest extends Model
{
    use Genderable;
    protected $fillable = [
        'full_name', 'student_code', 'gender', 'dob', 'phone',
        'address', 'reason', 'priority_level_id',
        'status', 'note',
        'approved_by', 'approved_at',
        'rejected_by', 'rejected_at', 'rejected_reason'
    ];

    public function priority()
    {
        return $this->belongsTo(PriorityLevel::class, 'priority_level_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function isOldStudent()
    {
        return DormitoryRecord::whereHas('user.profile', function ($q) {
            $q->where('student_code', $this->student_code);
        })->exists();
    }
    public function student()
{
    return $this->belongsTo(StudentOfficial::class, 'student_code', 'student_code');
}
}
