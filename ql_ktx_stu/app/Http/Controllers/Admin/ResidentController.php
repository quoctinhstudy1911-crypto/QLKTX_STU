<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DormitoryRecord;
use App\Models\Room;
use App\Models\Bed;
use App\Models\HocKy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{    /**
     * ============================
     * 📌 1) DANH SÁCH SINH VIÊN LƯU TRÚ
     * ============================
     */
    public function index(Request $request)
{
    $query = DormitoryRecord::with(['user.profile','room','bed','hocKy'])
        ->where('is_active', true);

    // --- FILTER ---
    if ($request->filled('gender')) {
        $query->whereHas('room', fn($q) => $q->where('gender',$request->gender));
    }

    if ($request->filled('room_id')) {
        $query->where('room_id', $request->room_id);
    }

    if ($request->filled('hoc_ky_id')) {
        $query->where('hoc_ky_id', $request->hoc_ky_id);
    }

    if ($request->filled('q')) {
        $s = $request->q;
        $query->whereHas('user.profile', fn($q) =>
            $q->where('student_code','like',"%$s%")
              ->orWhere('full_name','like',"%$s%")
        );
    }

    $records = $query->orderBy('check_in_date','desc')->paginate(12)->withQueryString();

    $rooms = Room::orderBy('room_number')->get();
    $hocKys = HocKy::orderBy('school_year','desc')->get();

    // ⭐ CHUẨN HOÁ DATA GIƯỜNG TRỐNG ĐỂ ĐẨY SANG JS
    $roomBedMap = Room::with(['beds' => fn($q) => $q->where('status','available')])
        ->get()
        ->map(fn($r) => [
            'id' => $r->id,
            'number' => $r->room_number,
            'beds' => $r->beds->map(fn($b)=>[
                'id'=>$b->id,
                'code'=>$b->bed_code
            ])
        ]);

    return view('admin.pages.residents.index',
        compact('records','rooms','hocKys','roomBedMap')
    );
}

    /**
     * ============================
     * 📌 2) CHUYỂN PHÒNG
     * ============================
     */
    public function changeRoom(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_id'  => 'required|exists:beds,id',
        ]);

        $record = DormitoryRecord::findOrFail($id);

        DB::beginTransaction();
        try {
            // Giải phóng giường cũ
            if ($record->bed) {
                $record->bed->update(['status' => 'available']);
            }

            // Kiểm tra giường mới
            $newBed = Bed::where('id', $request->bed_id)
                         ->where('room_id', $request->room_id)
                         ->where('status','available')
                         ->first();

            if (!$newBed) {
                return back()->with('error','Giường mới không hợp lệ hoặc đã được dùng.');
            }

            // Chiếm giường mới
            $newBed->update(['status' => 'occupied']);

            // Cập nhật record
            $record->update([
                'room_id' => $request->room_id,
                'bed_id' => $newBed->id
            ]);

            DB::commit();
            return back()->with('success','Đổi phòng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Lỗi: '.$e->getMessage());
        }
    }

    /**
     * ============================
     * 📌 3) GIA HẠN LƯU TRÚ
     * ============================
     */
    public function extendStay(Request $request, $id)
    {
        $request->validate([
            'new_check_out' => 'required|date|after:today',
        ]);

        $record = DormitoryRecord::findOrFail($id);
        $record->update([
            'check_out_date' => $request->new_check_out
        ]);

        return back()->with('success','Gia hạn lưu trú thành công.');
    }

    /**
     * ============================
     * 📌 4) TRẢ PHÒNG
     * ============================
     */
    public function checkout(Request $request, $id)
    {
        $record = DormitoryRecord::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($record->bed) {
                $record->bed->update(['status' => 'available']);
            }

            $record->update([
                'is_active' => false,
                'check_out_date' => now(),
                'reason_leave' => $request->reason_leave ?? null
            ]);

            DB::commit();
            return back()->with('success','Trả phòng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Lỗi: '.$e->getMessage());
        }
    }

    /**
     * ============================
     * 📌 5) LỊCH SỬ LƯU TRÚ
     * ============================
     */
    public function history($userId)
    {
        $history = DormitoryRecord::with(['room','bed','hocKy'])
            ->where('user_id',$userId)
            ->orderBy('check_in_date','desc')
            ->paginate(20);

        return view('admin.pages.residents.history', compact('history'));
    }
}
