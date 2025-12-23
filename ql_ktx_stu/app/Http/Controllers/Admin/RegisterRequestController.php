<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegisterRequest;
use App\Models\PriorityLevel;
use App\Models\Room;
use App\Models\Bed;
use App\Models\User;
use App\Models\PersonalProfile;
use App\Models\DormitoryRecord;
use App\Models\HocKy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentAccountCreated;

class RegisterRequestController extends Controller
{
    /**
     * DANH SÁCH HỒ SƠ ĐĂNG KÝ (CÓ LỌC THEO TRẠNG THÁI)
     */
    public function index(Request $request)
    {
        $status = $request->status;

        $requests = RegisterRequest::with('priority')
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pages.register-requests.index', compact('requests', 'status'));
    }

    /**
     * XEM CHI TIẾT HỒ SƠ
     * - Thông tin đăng ký
     * - Diện ưu tiên
     * - Gợi ý phòng phù hợp giới tính
     * - Danh sách giường trống
     */
    public function show($id)
    {
        $req = RegisterRequest::with('priority')->findOrFail($id);

        // Chuẩn hóa giới tính (xử lý cả 'Nam', 'Nữ', 'male', 'female')
        $normalizedGender = null;
        if ($req->gender) {
            $normalizedGender = method_exists($req, 'normalizeGender')
                ? RegisterRequest::normalizeGender($req->gender)
                : $req->gender;
        }

        // Lấy danh sách phòng phù hợp giới tính và còn giường trống
        $rooms = Room::withCount([
                'beds as used_beds' => fn($q) => $q->where('status', 'occupied'),
                'beds as total_beds'
            ])
            ->when($normalizedGender, fn($q) => $q->where('gender', $normalizedGender))
            ->get()
            ->filter(fn($room) => $room->used_beds < $room->total_beds);

        // Lấy danh sách giường trống theo từng phòng
        $availableBeds = Bed::where('status', 'available')
            ->whereIn('room_id', $rooms->pluck('id')->toArray())
            ->orderBy('room_id')
            ->orderBy('bed_code')
            ->get()
            ->groupBy('room_id');

        // Kiểm tra sinh viên cũ hay mới
        $isOld = $req->isOldStudent();

        return view(
            'admin.pages.register-requests.show',
            compact('req', 'rooms', 'availableBeds', 'isOld')
        );
    }

    /**
     * DUYỆT HỒ SƠ ĐĂNG KÝ
     * - Admin chọn giường cụ thể hoặc chọn phòng
     * - Tạo tài khoản sinh viên (nếu chưa có)
     * - Phân phòng – giường
     * - Ghi nhận lịch sử lưu trú
     */
    public function approve(Request $request, $id)
    {
        $req = RegisterRequest::findOrFail($id);

        // Chỉ cho duyệt hồ sơ đang chờ
        if ($req->status !== 'pending') {
            return back()->with('error', 'Hồ sơ này đã được xử lý trước đó.');
        }

        $request->validate([
            'room_id'   => 'nullable|exists:rooms,id',
            'bed_id'    => 'nullable|exists:beds,id',
            'hoc_ky_id' => 'nullable|exists:hoc_kys,id',
        ]);

        DB::beginTransaction();
        try {
            /**
             * 1. Xác định giường sẽ cấp cho sinh viên
             */
            $targetBed = null;

            if ($request->filled('bed_id')) {
                $targetBed = Bed::where('id', $request->bed_id)
                    ->where('status', 'available')
                    ->first();

                if (!$targetBed) {
                    return back()->with('error', 'Giường đã chọn không hợp lệ hoặc đã bị chiếm.');
                }
            } elseif ($request->filled('room_id')) {
                $targetBed = Bed::where('room_id', $request->room_id)
                    ->where('status', 'available')
                    ->first();

                if (!$targetBed) {
                    return back()->with('error', 'Phòng này hiện không còn giường trống.');
                }
            } else {
                return back()->with('error', 'Vui lòng chọn phòng hoặc giường để xếp.');
            }

            /**
             * 2. Tạo hoặc lấy tài khoản sinh viên
             */
           $studentCode = $req->student_code; // VD: DH52201580

            $email = strtolower(substr($studentCode, 0, 2)) 
                . substr($studentCode, 2) 
                . '@student.stu.edu.vn';

           // 1. Tạo hoặc lấy tài khoản sinh viên
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'password' => Hash::make('123456'),
                        'role' => 'student'
                    ]
                );

               
            /**
             * 3. Tạo hoặc cập nhật hồ sơ cá nhân sinh viên
             */
            PersonalProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $req->full_name,
                    'student_code' => $req->student_code,
                    'gender' => $req->gender,
                    'dob' => $req->dob,
                    'phone' => $req->phone,
                    'address' => $req->address,
                ]
            );

            /**
             * 4. Đánh dấu giường đã có người ở
             */
            $targetBed->update(['status' => 'occupied']);

            /**
             * 5. Xác định học kỳ áp dụng
             */
            $hocKyId = $request->hoc_ky_id;

            if (!$hocKyId) {
                $activeHocKy = HocKy::where('is_active', true)->first();
                if ($activeHocKy) {
                    $hocKyId = $activeHocKy->id;
                }
            }

            if (!$hocKyId) {
                $hocKyId = HocKy::orderBy('id', 'desc')->value('id') ?? 1;
            }

            /**
             * 6. Ghi nhận lịch sử lưu trú
             */
            DormitoryRecord::create([
                'user_id' => $user->id,
                'hoc_ky_id' => $hocKyId,
                'room_id' => $targetBed->room_id,
                'bed_id' => $targetBed->id,
                'check_in_date' => now(),
            ]);

            /**
             * 7. Cập nhật trạng thái hồ sơ đăng ký
             */
            $req->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            DB::commit();
           //Chỉ gửi mail khi tài khoản vừa được tạo
                if ($user->wasRecentlyCreated) {
                    Mail::to($user->email)->send(
                        new StudentAccountCreated($user->email, '123456')
                    );
                }


            return redirect()
                ->route('admin.register-requests.index')
                ->with('success', 'Duyệt hồ sơ và xếp phòng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra trong quá trình xử lý.');
        }
    }

    /**
     * TỪ CHỐI HỒ SƠ ĐĂNG KÝ
     */
    public function reject(Request $request, $id)
    {
        $req = RegisterRequest::findOrFail($id);

        $request->validate([
            'rejected_reason' => 'required|string'
        ]);

        $req->update([
            'status' => 'rejected',
            'rejected_reason' => $request->rejected_reason,
            'rejected_by' => auth()->id(),
            'rejected_at' => now()
        ]);

        return back()->with('success', 'Đã từ chối hồ sơ đăng ký.');
    }
}
