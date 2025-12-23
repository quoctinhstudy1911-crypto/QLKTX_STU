@extends('guest.layouts.master')

@section('title', 'Hướng Dẫn Sử Dụng')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="page-header mb-4">
            <h1 class="page-title">
                📚 Hướng Dẫn Sử Dụng Hệ Thống Nội Trú
            </h1>
            <p class="page-subtitle">
                Hướng dẫn chi tiết từng bước đăng ký nội trú và theo dõi kết quả xét duyệt
            </p>
        </div>

        {{-- ===== STEP 1 ===== --}}
        <div class="card step-card">
            <div class="card-body d-flex gap-3">
                <div class="step-badge">1</div>
                <div>
                    <h3 class="step-title">Chuẩn Bị Thông Tin</h3>
                    <p class="text-muted">
                        Trước khi đăng ký, sinh viên cần chuẩn bị đầy đủ các thông tin sau:
                    </p>
                    <ul class="info-list">
                        <li><strong>Mã sinh viên (MSSV):</strong> Do trường cấp</li>
                        <li><strong>Họ và tên:</strong> Ghi đúng theo hồ sơ</li>
                        <li><strong>Số điện thoại:</strong> Dùng để liên hệ</li>
                        <li><strong>Địa chỉ hiện tại:</strong> Nơi đang sinh sống</li>
                        <li><strong>Lý do đăng ký:</strong> Trình bày rõ ràng, trung thực</li>
                        <li><strong>Mức độ ưu tiên:</strong> Nếu thuộc diện đặc biệt</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ===== STEP 2 ===== --}}
        <div class="card step-card">
            <div class="card-body d-flex gap-3">
                <div class="step-badge">2</div>
                <div>
                    <h3 class="step-title">Truy Cập Trang Đăng Ký</h3>
                    <p class="text-muted">
                        Sinh viên truy cập vào trang đăng ký nội trú thông qua nút bên dưới:
                    </p>
                    <a href="{{ route('guest.register') }}" class="btn btn-primary mt-2">
                        ✏️ Đến Trang Đăng Ký
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== STEP 3 ===== --}}
        <div class="card step-card">
            <div class="card-body d-flex gap-3">
                <div class="step-badge">3</div>
                <div>
                    <h3 class="step-title">Điền Thông Tin Đăng Ký</h3>
                    <p class="text-muted">
                        Điền đầy đủ và chính xác tất cả các trường thông tin trong form.
                    </p>
                    <ul class="info-list">
                        <li><strong>Mã sinh viên:</strong> Bắt buộc, phải tồn tại trong hệ thống</li>
                        <li><strong>Họ và tên:</strong> Không viết tắt</li>
                        <li><strong>Số điện thoại:</strong> Đúng định dạng</li>
                        <li><strong>Địa chỉ:</strong> Ghi rõ ràng</li>
                        <li><strong>Lý do đăng ký:</strong> Càng chi tiết càng tốt</li>
                        <li><strong>Mức độ ưu tiên:</strong> Chọn nếu có</li>
                    </ul>
                    <p class="text-danger mt-2">
                        ⚠️ Lưu ý: Mã sinh viên không hợp lệ sẽ khiến đơn bị từ chối.
                    </p>
                </div>
            </div>
        </div>

        {{-- ===== STEP 4 ===== --}}
        <div class="card step-card">
            <div class="card-body d-flex gap-3">
                <div class="step-badge">4</div>
                <div>
                    <h3 class="step-title">Gửi Đơn Đăng Ký</h3>
                    <p class="text-muted">
                        Sau khi kiểm tra lại thông tin, nhấn <strong>Gửi Đơn Đăng Ký</strong>.
                    </p>
                    <p class="text-success">
                        ✅ Hệ thống sẽ hiển thị thông báo khi gửi thành công.
                    </p>
                </div>
            </div>
        </div>

        {{-- ===== STEP 5 ===== --}}
        <div class="card step-card">
            <div class="card-body d-flex gap-3">
                <div class="step-badge">5</div>
                <div>
                    <h3 class="step-title">Tra Cứu Trạng Thái</h3>
                    <p class="text-muted">
                        Sinh viên có thể kiểm tra trạng thái đơn đăng ký bất kỳ lúc nào.
                    </p>
                    <a href="{{ route('guest.status') }}" class="btn btn-info mt-2">
                        🔍 Tra Cứu Trạng Thái
                    </a>
                    <ul class="info-list mt-3">
                        <li>Trạng thái: Chờ duyệt / Được duyệt / Bị từ chối</li>
                        <li>Ngày gửi đơn</li>
                        <li>Lý do từ chối (nếu có)</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ===== STEP 6 ===== --}}
        <div class="card step-card">
            <div class="card-body d-flex gap-3">
                <div class="step-badge">6</div>
                <div>
                    <h3 class="step-title">Khi Đơn Được Duyệt</h3>
                    <ul class="info-list">
                        <li>📧 Nhận email thông báo</li>
                        <li>🔑 Tạo tài khoản sinh viên</li>
                        <li>👤 Hoàn thiện hồ sơ cá nhân</li>
                        <li>🏠 Xem thông tin phòng ở được phân</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ===== HELPFUL NOTE ===== --}}
        <div class="alert alert-info mt-4">
            <strong>💡 Lưu ý quan trọng:</strong>
            <ul class="mt-2 mb-0">
                <li>Kiểm tra kỹ mã sinh viên trước khi gửi</li>
                <li>Lý do đăng ký nên trình bày rõ ràng</li>
                <li>Giữ số điện thoại hoạt động</li>
                <li>Liên hệ phòng quản lý nếu gặp sự cố</li>
            </ul>
        </div>

        {{-- ===== ACTION BUTTONS ===== --}}
        <div class="d-flex flex-wrap gap-2 mt-4">
            <a href="{{ route('guest.register') }}" class="btn btn-primary">
                ✏️ Đăng Ký Nội Trú
            </a>
            <a href="{{ route('guest.status') }}" class="btn btn-info">
                🔍 Tra Cứu
            </a>
            <a href="{{ route('guest.home') }}" class="btn btn-secondary">
                🏠 Trang Chủ
            </a>
        </div>

    </div>
</div>

@endsection
