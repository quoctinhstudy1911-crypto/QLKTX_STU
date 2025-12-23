<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentOfficial;
use App\Models\RegisterRequest;
use App\Models\PriorityLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo các mức ưu tiên
        $priorities = [
            ['name' => 'Bình thường', 'description' => 'Sinh viên bình thường', 'score' => 0, 'active' => true],
            ['name' => 'Ưu tiên 1', 'description' => 'Từ ngoài tỉnh', 'score' => 10, 'active' => true],
            ['name' => 'Ưu tiên 2', 'description' => 'Từ xã hội hóa', 'score' => 5, 'active' => true],
            ['name' => 'Ưu tiên cao', 'description' => 'Học bổng, tấm gương', 'score' => 20, 'active' => true],
        ];

        foreach ($priorities as $priority) {
            PriorityLevel::firstOrCreate(['name' => $priority['name']], $priority);
        }

        // Tạo tài khoản admin nếu chưa có
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        // Tạo các sinh viên chính thức - sử dụng DB để tránh observer
      $students = [
    [
        'student_code' => 'DH52201580',
        'full_name' => 'Nguyễn Quốc Tính',
        'gender' => 'male',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH02',
        'email' => 'dh52201580@student.stu.edu.vn'
    ],
    [
        'student_code' => 'DH52201582',
        'full_name' => 'Phạm Văn K',
        'gender' => 'male',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH02',
        'email' => 'dh52201582@student.stu.edu.vn'
    ],
    [
        'student_code' => 'DH52201583',
        'full_name' => 'Lê Thị O',
        'gender' => 'female',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH02',
        'email' => 'dh52201583@student.stu.edu.vn'
    ],
    [
        'student_code' => 'DH52201584',
        'full_name' => 'Hoàng Văn P',
        'gender' => 'male',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH02',
        'email' => 'dh52201584@student.stu.edu.vn'
    ],
    [
        'student_code' => 'DH52201585',
        'full_name' => 'Phạm Thị Quỳnh',
        'gender' => 'female',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH03',
        'email' => 'dh52201585@student.stu.edu.vn'
    ],
    [
        'student_code' => 'DH52201586',
        'full_name' => 'Đỗ Minh Anh',
        'gender' => 'female',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH03',
        'email' => 'dh52201586@student.stu.edu.vn'
    ],
    [
        'student_code' => 'DH52201587',
        'full_name' => 'Nguyễn Thị Lan',
        'gender' => 'female',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH03',
        'email' => 'dh52201587@student.stu.edu.vn'
    ],
    [
        'student_code' => 'DH52201588',
        'full_name' => 'Trần Văn Bảo',
        'gender' => 'male',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH04',
        'email' => 'dh52201588@student.stu.edu.vn'
    ],
    [
        'student_code' => 'DH52201589',
        'full_name' => 'Võ Thị Hồng',
        'gender' => 'female',
        'department' => 'Công Nghệ Thông Tin',
        'class_name' => 'D22_TH04',
        'email' => 'dh52201589@student.stu.edu.vn'
    ],
];

        foreach ($students as $student) {
            // Kiểm tra xem sinh viên đã tồn tại chưa
            if (!StudentOfficial::where('student_code', $student['student_code'])->exists()) {
                DB::table('students_official')->insert($student);
            }
        }

$registerRequests = [

    // ============================
    // 1) Đơn PENDING (chưa xét duyệt)
    // ============================

    [
        'full_name' => 'Nguyễn Quốc Tính',
        'student_code' => 'DH52201580',
        'gender' => 'male',
        'dob' => '2004-05-15',
        'phone' => '0912345678',
        'address' => '123 Đường Nguyễn Huệ, Quận 1, TP HCM',
        'reason' => 'Tôi là sinh viên từ tỉnh Cần Thơ, cần nơi ở gần trường để học tập tốt hơn.',
        'priority_level_id' => 1, // Bình thường
        'status' => 'pending',
        'note' => null,
        'approved_by' => null,
        'approved_at' => null,
        'rejected_by' => null,
        'rejected_at' => null,
        'rejected_reason' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'full_name' => 'Phạm Văn K',
        'student_code' => 'DH52201582',
        'gender' => 'male',
        'dob' => '2004-08-22',
        'phone' => '0987654321',
        'address' => '456 Đường Lý Thường Kiệt, Quận 10, TP HCM',
        'reason' => 'Quê tôi ở Long An, rất xa trường. Xin phép ở ký túc xá để tiết kiệm thời gian đi lại.',
        'priority_level_id' => 2, // Ưu tiên 1
        'status' => 'pending',
        'note' => null,
        'approved_by' => null,
        'approved_at' => null,
        'rejected_by' => null,
        'rejected_at' => null,
        'rejected_reason' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'full_name' => 'Lê Thị O',
        'student_code' => 'DH52201583',
        'gender' => 'female',
        'dob' => '2004-04-10',
        'phone' => '0923456789',
        'address' => '789 Đường Võ Văn Kiệt, Quận 5, TP HCM',
        'reason' => 'Tôi muốn ở KTX để tiện cho việc học và tham gia hoạt động của trường.',
        'priority_level_id' => 4, // Ưu tiên cao
        'status' => 'pending',
        'note' => 'Cần bổ sung giấy xác nhận gia đình khó khăn',
        'approved_by' => null,
        'approved_at' => null,
        'rejected_by' => null,
        'rejected_at' => null,
        'rejected_reason' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ],


    // ============================
    // 2) Đơn APPROVED (đã phê duyệt)
    // ============================

    [
        'full_name' => 'Phạm Thị Quỳnh',
        'student_code' => 'DH52201585',
        'gender' => 'female',
        'dob' => '2004-11-05',
        'phone' => '0934567890',
        'address' => '321 Đường Trần Hưng Đạo, Quận 1, TP HCM',
        'reason' => 'Xin phép ở ký túc xá để học tập và phát triển kỹ năng.',
        'priority_level_id' => 1, // Bình thường
        'status' => 'approved',
        'note' => 'Đã phê duyệt - Xếp phòng A101',
        'approved_by' => $admin->id,
        'approved_at' => now()->subDays(5),
        'rejected_by' => null,
        'rejected_at' => null,
        'rejected_reason' => null,
        'created_at' => now()->subDays(7),
        'updated_at' => now()->subDays(5),
    ],

    [
        'full_name' => 'Đỗ Minh Anh',
        'student_code' => 'DH52201586',
        'gender' => 'female',
        'dob' => '2004-07-18',
        'phone' => '0945678901',
        'address' => '654 Đường Nguyễn Thái Học, Quận 3, TP HCM',
        'reason' => 'Gia đình ở Tiền Giang, muốn ở KTX để tiện đi học.',
        'priority_level_id' => 2, // Ưu tiên 1
        'status' => 'approved',
        'note' => 'Đã phê duyệt - Xếp phòng B205',
        'approved_by' => $admin->id,
        'approved_at' => now()->subDays(3),
        'rejected_by' => null,
        'rejected_at' => null,
        'rejected_reason' => null,
        'created_at' => now()->subDays(5),
        'updated_at' => now()->subDays(3),
    ],


    // ============================
    // 3) Đơn REJECTED (bị từ chối)
    // ============================

    [
        'full_name' => 'Võ Thị Hồng',
        'student_code' => 'DH52201589',
        'gender' => 'female',
        'dob' => '2004-09-12',
        'phone' => '0956789012',
        'address' => '987 Đường Phan Bội Châu, Quận 4, TP HCM',
        'reason' => 'Xin ở ký túc xá',
        'priority_level_id' => 3, // Ưu tiên 2
        'status' => 'rejected',
        'note' => 'Lý do từ chối: Sinh viên là người Tp.HCM, ở gần trường',
        'approved_by' => null,
        'approved_at' => null,
        'rejected_by' => $admin->id,
        'rejected_at' => now()->subDays(7),
        'rejected_reason' => 'Sinh viên là người Tp.HCM, ở gần trường. Không đủ điều kiện để ở KTX.',
        'created_at' => now()->subDays(9),
        'updated_at' => now()->subDays(7),
    ],
];



        foreach ($registerRequests as $request) {
            if (!RegisterRequest::where('student_code', $request['student_code'])->where('status', $request['status'])->exists()) {
                DB::table('register_requests')->insert($request);
            }
        }

        echo "✓ Tạo thành công dữ liệu mẫu\n";
        echo "✓ Các mức ưu tiên: " . PriorityLevel::count() . " cấp độ\n";
        echo "✓ Sinh viên: " . DB::table('students_official')->count() . " sinh viên\n";
        echo "✓ Đơn đăng ký: " . DB::table('register_requests')->count() . " đơn\n";
        echo "✓ Admin test: admin@test.com (pass: 123456)\n";
    }
}
