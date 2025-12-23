<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Genderable;

class StudentOfficial extends Model

{
    use Genderable;
    protected $table = 'students_official';
    public $timestamps = false;

    protected $fillable = [
        'student_code',
        'full_name',
        'gender',
        'department',
        'class_name',
        'email',
    ];
}
