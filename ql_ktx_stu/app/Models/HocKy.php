<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HocKy extends Model
{
    public $timestamps = false;
    
    protected $table = 'hoc_kys';
    protected $fillable = [
        'school_year',
        'semester',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function dormitoryRecords()
    {
        return $this->hasMany(DormitoryRecord::class, 'hoc_ky_id');
    }
}
