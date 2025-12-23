<?php
namespace App\Traits;

use App\Models\ActivityLog;

trait ActivityLogger
{
    public function logActivity($action, $description = null)
    {
        ActivityLog::create([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'action'     => $action,
            'description'=> $description,
            'ip_address' => request()?->ip(),
        ]);
    }
}
