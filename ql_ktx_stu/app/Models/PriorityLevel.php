<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityLevel extends Model
{
    protected $fillable = ['name', 'description', 'score', 'active'];

    public function registerRequests()
    {
        return $this->hasMany(RegisterRequest::class);
    }
}
