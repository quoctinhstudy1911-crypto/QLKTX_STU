<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Bed;
use App\Models\DormitoryRecord;
use App\Models\RegisterRequest;
use App\Models\StudentOfficial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Hiển thị dashboard
     */
    public function index()
    {
        // Thống kê cơ bản
        $totalRooms = Room::count();
        $availableBeds = Bed::where('status', 'available')->count();
        $totalStudentsLiving = DormitoryRecord::where('is_active', 1)->count();
        $pendingRequests = RegisterRequest::where('status', 'pending')->count();
        
        // Thống kê chi tiết
        $totalBeds = Bed::count();
        $totalStudentsOfficial = StudentOfficial::count();
        $totalUsers = \App\Models\User::count();
        $approvedRequests = RegisterRequest::where('status', 'approved')->count();
        $rejectedRequests = RegisterRequest::where('status', 'rejected')->count();

        // Thống kê theo giới tính phòng
        $roomsByGender = Room::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get();

        // Thống kê giường theo trạng thái
        $bedsByStatus = Bed::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Danh sách sinh viên lưu trú gần đây (5 người)
        $recentResidents = DormitoryRecord::where('is_active', 1)
            ->with(['profile', 'room', 'bed'])
            ->latest('check_in_date')
            ->limit(5)
            ->get();

        // Danh sách đăng ký chờ duyệt (5 người)
        $pendingRegisterRequests = RegisterRequest::where('status', 'pending')
            ->with('student')
            ->latest('created_at')
            ->limit(5)
            ->get();

        // Thống kê độ kín của phòng
        $roomOccupancy = Room::with('beds')
            ->get()
            ->map(function ($room) {
                $totalCapacity = $room->beds->count();
                $occupied = $room->beds->filter(fn($bed) => $bed->status !== 'available')->count();
                $occupancyRate = $totalCapacity > 0 ? ($occupied / $totalCapacity) * 100 : 0;
                return [
                    'room_number' => $room->room_number,
                    'capacity' => $totalCapacity,
                    'occupied' => $occupied,
                    'occupancy_rate' => round($occupancyRate, 1),
                ];
            })
            ->sortByDesc('occupancy_rate')
            ->take(10)
            ->values();

        return view('admin.pages.dashboard', compact(
            'totalRooms',
            'availableBeds',
            'totalStudentsLiving',
            'pendingRequests',
            'totalBeds',
            'totalStudentsOfficial',
            'totalUsers',
            'approvedRequests',
            'rejectedRequests',
            'roomsByGender',
            'bedsByStatus',
            'recentResidents',
            'pendingRegisterRequests',
            'roomOccupancy'
        ));
    }
}
