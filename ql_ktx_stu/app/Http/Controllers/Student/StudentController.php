<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\RegisterRequest;
use App\Models\PersonalProfile;
use App\Models\DormitoryRecord;
use App\Models\Room;
use App\Models\User;
use App\Models\Bed;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    // Trang chủ sinh viên sau khi đăng nhập
    public function dashboard()
    {
        $user = Auth::user();
        $profile = $user->profile; // quan hệ hasOne PersonalProfile
        $currentRecord = $user->dormitoryRecords()
                              ->where('is_active', true)
                              ->first();
        //StudentOfficial của sinh viên để lấy khoa và lớp học
        $studentOfficial = $profile->studentOfficial;

        return view('student.pages.dashboard', compact('user', 'profile', 'currentRecord', 'studentOfficial'));
    }

    // Xem thông tin phòng + giường hiện tại
    public function roomInfo()
    {
        $record = Auth::user()->dormitoryRecords()
                       ->where('is_active', true)
                       ->with(['room', 'bed'])
                       ->first();

        return view('student.pages.room', compact('record'));
    }

    // Xem lịch sử lưu trú
    public function history()
    {
        $records = Auth::user()->dormitoryRecords()
                       ->with(['room', 'bed', 'hocKy'])
                       ->orderByDesc('check_in_date')
                       ->paginate(10);

        return view('student.pages.history', compact('records'));
    }

    // Trang hồ sơ cá nhân
    public function profile()
    {
        $profile = Auth::user()->profile;
        //StudentOfficial của sinh viên để lấy khoa và lớp học
        $studentOfficial = $profile->studentOfficial;
        return view('student.pages.profile', compact('profile', 'studentOfficial'));
    }

    // Cập nhật hồ sơ cá nhân (chỉ những trường được phép sửa)
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|max:15',
            'address'  => 'nullable|string|max:255',
            'hometown' => 'nullable|string|max:255',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $profile = Auth::user()->profile;

        $data = [
            'phone'   => $request->phone,
            'address' => $request->address,
            'hometown' => $request->hometown,
        ];

        // Upload avatar
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Xóa avatar cũ nếu có
            if ($profile->avatar) {
                Storage::disk('public')->delete('avatars/' . $profile->avatar);
            }
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->extension();
            Storage::disk('public')->putFileAs('avatars', $file, $fileName);
            $data['avatar'] = $fileName;
        }

        $profile->update($data);

        return back()->with('success', 'Cập nhật hồ sơ thành công!');
    }

    // Đổi mật khẩu
    public function passwordForm()
    {
        return view('student.pages.password');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password'          => 'required',
            'password'                  => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng!']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('student.dashboard')
                         ->with('success', 'Đổi mật khẩu thành công!');
    }

    // Xem trạng thái hồ sơ đăng ký (nếu sinh viên từng đăng ký trước khi có tài khoản)
    public function registrationStatus(Request $request)
    {
        $studentCode = Auth::user()->profile->student_code ?? null;

        if (!$studentCode) {
            return view('student.pages.status')->with('message', 'Chưa có thông tin mã sinh viên.');
        }

        $register = RegisterRequest::where('student_code', $studentCode)
                                   ->latest()
                                   ->first();

        return view('student.pages.status', compact('register'));
    }
}