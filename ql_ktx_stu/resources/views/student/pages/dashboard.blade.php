@extends('student.layouts.app')

@section('title', 'Dashboard Sinh Viên')

@section('content')

<div class="row">

    <!-- WELCOME CARD -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="fw-bold mb-1">
                    👋 Chào mừng, {{ $profile->full_name ?? $user->email }}
                </h2>
                <p class="text-muted mb-0">
                    Đây là trang tổng quan thông tin cư xá của bạn.
                </p>
            </div>
        </div>
    </div>

    <!-- LEFT SIDE (ROOM + PROFILE) -->
    <div class="col-lg-8">

        {{-- ROOM INFO --}}
        @if ($currentRecord)
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">🏠 Phòng - Giường Hiện Tại</h4>
                </div>
                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="p-3 rounded bg-light border">
                                <small class="text-muted">Số Phòng</small>
                                <h3 class="fw-bold mt-1">{{ $currentRecord->room->room_number }}</h3>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded bg-light border">
                                <small class="text-muted">Số Giường</small>
                                <h3 class="fw-bold mt-1">{{ $currentRecord->bed->bed_code }}</h3>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded bg-light border">
                                <small class="text-muted">Loại Phòng</small>
                                <h5 class="fw-bold mt-1">{{ $currentRecord->room->room_type ?? 'N/A' }}</h5>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded bg-light border">
                                <small class="text-muted">Ngày Bắt Đầu</small>
                                <h5 class="fw-bold text-success mt-1">
                                    {{ \Carbon\Carbon::parse($currentRecord->check_in_date)->format('d/m/Y') }}
                                </h5>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        @else
            <div class="alert alert-warning shadow-sm mb-4">
                ⚠️ <strong>Bạn chưa được xếp phòng.</strong>  
                Vui lòng hoàn tất hồ sơ đăng ký cư xá.
            </div>
        @endif

        {{-- PROFILE INFO --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="card-title mb-0">👤 Thông Tin Cá Nhân</h4>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped mb-0">

                        <tr>
                            <th class="text-muted">Họ Tên</th>
                            <td class="fw-bold">{{ $profile->full_name ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">MSSV</th>
                            <td class="fw-bold">{{ $profile->student_code ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">Lớp</th>
                            <td class="fw-bold">{{ $studentOfficial->class_name ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">Khoa</th>
                            <td class="fw-bold">{{ $studentOfficial->department ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">Số Điện Thoại</th>
                            <td class="fw-bold">{{ $profile->phone ?? 'N/A' }}</td>
                        </tr>

                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- RIGHT COLUMN (OPTIONAL WIDGETS) -->
    <div class="col-lg-4">

        <!-- Quick Actions -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">⚡ Tác Vụ Nhanh</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('student.profile') }}" class="btn btn-primary w-100 mb-2">Cập nhật hồ sơ</a>
                <a href="{{ route('student.room') }}" class="btn btn-outline-primary w-100 mb-2">Xem phòng của tôi</a>
                <a href="{{ route('student.history') }}" class="btn btn-outline-secondary w-100">Lịch sử lưu trú</a>
            </div>
        </div>

        <!-- Card Summary -->
        @if($currentRecord)
        <div class="card shadow-sm">
            <div class="card-body text-center">

                <span class="badge bg-success mb-2 p-2">
                    ✓ Đang cư trú
                </span>

                <h5 class="fw-bold mt-2">{{ $currentRecord->room->room_number }}</h5>
                <p class="text-muted mb-1">Phòng hiện tại</p>

                <h6 class="fw-bold">{{ $currentRecord->bed->bed_code }}</h6>
                <p class="text-muted mb-3">Giường</p>

                <small class="text-muted">
                    Bắt đầu từ:  
                    <strong>{{ \Carbon\Carbon::parse($currentRecord->check_in_date)->format('d/m/Y') }}</strong>
                </small>

            </div>
        </div>
        @endif

    </div>

</div>
@endsection
