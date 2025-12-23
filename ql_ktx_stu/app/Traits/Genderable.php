<?php

namespace App\Traits;

trait Genderable
{
    /**
     * Giá trị giới tính Nam (lưu trong CSDL)
     */
    public static function genderMale(): string
    {
        return 'male';
    }

    /**
     * Giá trị giới tính Nữ (lưu trong CSDL)
     */
    public static function genderFemale(): string
    {
        return 'female';
    }

    /**
     * Chuẩn hóa giá trị giới tính về dạng lưu trữ chuẩn ('male' | 'female')
     *
     * Hỗ trợ nhiều kiểu nhập khác nhau:
     * - Tiếng Anh: male, female, M, F
     * - Tiếng Việt: nam, nữ, Nam, Nữ
     * - Có hoặc không dấu
     */
    public static function normalizeGender($value)
    {
        if ($value === null) return null;

        // Chuyển về chữ thường và loại bỏ khoảng trắng
        $s = mb_strtolower(trim((string)$value));

        // Chuyển ký tự có dấu sang không dấu (xử lý tiếng Việt)
        $trans = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);
        if ($trans !== false) {
            $s = $trans;
        }

        // Loại bỏ các ký tự không phải chữ và số
        $s = preg_replace('/[^a-z0-9]/', '', $s);

        // Các giá trị đại diện cho Nam và Nữ
        $maleCandidates = ['male', 'm', 'nam'];
        $femaleCandidates = ['female', 'f', 'nu'];

        if (in_array($s, $maleCandidates, true)) {
            return self::genderMale();
        }

        if (in_array($s, $femaleCandidates, true)) {
            return self::genderFemale();
        }

        // Trường hợp đặc biệt: kiểm tra chuỗi con
        if (strpos($s, 'male') !== false) {
            return self::genderMale();
        }

        if (strpos($s, 'female') !== false) {
            return self::genderFemale();
        }

        // Không xác định được
        return null;
    }

    /**
     * Kiểm tra đối tượng hiện tại có giới tính Nam hay không
     */
    public function isMale(): bool
    {
        return strtolower((string)$this->gender) === self::genderMale();
    }

    /**
     * Kiểm tra đối tượng hiện tại có giới tính Nữ hay không
     */
    public function isFemale(): bool
    {
        return strtolower((string)$this->gender) === self::genderFemale();
    }

    /**
     * Lấy nhãn hiển thị giới tính (dùng cho giao diện)
     */
    public function getGenderLabelAttribute()
    {
        if ($this->isMale()) return 'Nam';
        if ($this->isFemale()) return 'Nữ';

        // Trường hợp dữ liệu không xác định
        return $this->gender ?: '—';
    }
}
