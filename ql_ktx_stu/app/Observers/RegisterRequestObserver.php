<?php

namespace App\Observers;

use App\Models\RegisterRequest;
use App\Traits\ActivityLogger;

class RegisterRequestObserver
{
    use ActivityLogger;

    public function created(RegisterRequest $request): void
    {
        $this->logActivity(
            'created',
            "Tạo đơn đăng ký cho sinh viên {$request->student_code} - {$request->full_name}"
        );
    }

    public function updated(RegisterRequest $request): void
    {
        if ($request->isDirty('status')) {

            if ($request->status === 'approved') {
                $description = "Duyệt đơn đăng ký sinh viên {$request->student_code}";
            } elseif ($request->status === 'rejected') {
                $reason = $request->rejected_reason ?? 'Không có lý do';
                $description = "Từ chối đơn đăng ký sinh viên {$request->student_code}. Lý do: {$reason}";
            } else {
                $description = "Cập nhật trạng thái đơn đăng ký sinh viên {$request->student_code}";
            }

        } else {
            $description = "Cập nhật đơn đăng ký sinh viên {$request->student_code}";
        }

        $this->logActivity(
            'updated',
            $description
        );
    }

    public function deleted(RegisterRequest $request): void
    {
        $this->logActivity(
            'deleted',
            "Xóa đơn đăng ký sinh viên {$request->student_code}"
        );
    }
}
