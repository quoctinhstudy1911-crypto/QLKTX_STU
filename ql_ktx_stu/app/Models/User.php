<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /** @return HasOne<PersonalProfile> */
    public function profile(): HasOne
    {
        return $this->hasOne(PersonalProfile::class, 'user_id');
    }

    /** @return HasMany<DormitoryRecord> */
    public function dormitoryRecords(): HasMany
    {
        return $this->hasMany(DormitoryRecord::class, 'user_id');
    }

    /** @return HasMany<ActivityLog> */
    public function logs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }
}