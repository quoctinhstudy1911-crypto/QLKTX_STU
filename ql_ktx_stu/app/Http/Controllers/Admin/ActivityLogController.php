<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with(['user.profile'])
        ->orderBy('id', 'desc')
        ->paginate(20);
        return view('admin.pages.activity.index', compact('logs'));
    }
}
