<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentOfficial;
use Illuminate\Http\Request;
use League\Csv\Reader;

class StudentOfficialController extends Controller
{    /**
     * Hiển thị form import CSV
     */
    public function importForm()
    {
        return view('admin.pages.students.import');
    }

    /**
     * Xử lý import file CSV
     */
  public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt|max:10240',
    ]);

    try {
        $file = $request->file('csv_file');
        $raw = file_get_contents($file->getRealPath());

        // Đổi về UTF-8 để không lỗi tiếng Việt
        $raw = mb_convert_encoding($raw, 'UTF-8', 'auto');

        // Xóa BOM UTF-8
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);

        // Tạo CSV reader
        $csv = Reader::createFromString($raw);
        $csv->setHeaderOffset(0);

        $imported = 0;
        $errors = [];

        foreach ($csv->getRecords() as $index => $record) {

            // ===========================
            //  VALIDATE BẮT BUỘC
            // ===========================
            if (empty($record['student_code']) || empty($record['full_name'])) {
                $errors[] = "Dòng " . ($index + 2) . ": Thiếu mã sinh viên hoặc họ tên.";
                continue;
            }

            // Check trùng mã SV
            if (StudentOfficial::where('student_code', trim($record['student_code']))->exists()) {
                $errors[] = "Dòng " . ($index + 2) . ": Mã SV '{$record['student_code']}' đã tồn tại.";
                continue;
            }

            // ===========================
            //  CHUẨN HÓA GIỚI TÍNH
            // ===========================
            $genderRaw = trim($record['gender'] ?? '');
            
            // Xóa khoảng trắng thừa
            $genderRaw = preg_replace('/\s+/', '', $genderRaw);

            // Map các lỗi encoding về Nam / Nữ
            $genderMap = [
                'Nam' => 'male',
                'nam' => 'male',
                'NAM' => 'male',

                'Nữ' => 'female',
                'Nu' => 'female',
                'NU' => 'female',
                'NÆ°' => 'female',
                'NÆ¯' => 'female',
                'Nư' => 'female',
                'NỮ' => 'female',
                'NN' => 'female', // Excel phá chữ "Nữ" thành "NN"
                'NÃ¡Â»Â¯' => 'female',
            ];

            $gender = $genderMap[$genderRaw] ?? null;

            // ===========================
            //  CHUẨN HÓA CÁC CỘT KHÁC
            // ===========================
            $department = isset($record['department']) ? trim($record['department']) : null;
            $class      = isset($record['class_name']) ? trim($record['class_name']) : null;
            $email      = isset($record['email']) ? trim($record['email']) : null;

            // ===========================
            //  INSERT VÀO DATABASE
            // ===========================
            StudentOfficial::create([
                'student_code' => trim($record['student_code']),
                'full_name'    => trim($record['full_name']),
                'gender'       => $gender,
                'department'   => $department,
                'class_name'   => $class,
                'email'        => $email,
            ]);

            $imported++;
        }

        // ===========================
        //  TRẢ VỀ KẾT QUẢ
        // ===========================
        $msg = "Đã import thành công $imported sinh viên.";

        if (!empty($errors)) {
            session()->flash('warnings', $errors);
            $msg .= " Có " . count($errors) . " dòng lỗi.";
        }

        return redirect()->route('admin.students.import')
                ->with('success', $msg);

    } catch (\Exception $e) {
        return back()->with('error', 'Lỗi khi xử lý file: ' . $e->getMessage());
    }
}


    /**
     * Hiển thị danh sách sinh viên chính thức
     */
    public function index()
    {
        $students = StudentOfficial::orderBy('student_code')->paginate(15);
        return view('admin.pages.students.index', compact('students'));
    }

}
