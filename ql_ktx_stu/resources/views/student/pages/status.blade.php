@extends('student.layouts.app')

@section('title', 'Trạng Thái Đăng Ký')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">

        <h1 class="h3 mb-3">📄 Trạng Thái Đăng Ký Cư Xá</h1>
        <p class="text-muted mb-4">Kiểm tra tiến trình xử lý hồ sơ của bạn</p>

        {{-- Trường hợp không tìm thấy --}}
        @if (isset($message))
            <div class="alert alert-warning text-center py-4 shadow-sm">
                <strong>⚠ {{ $message }}</strong>
            </div>
        @elseif(isset($register))

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">Hồ Sơ Đăng Ký</h4>
                </div>

                <div class="card-body">

                    {{-- STATUS BADGE --}}
                    <div class="mb-4">
                        @if ($register->status === 'approved')
                            <span class=" text-black badge bg-success px-3 py-2">✓ Được duyệt</span>
                        @elseif ($register->status === 'pending')
                            <span class="text-black badge bg-warning px-3 py-2">⏳ Chờ duyệt</span>
                        @else
                            <span class=" text-black badge bg-danger px-3 py-2">✗ Bị từ chối</span>
                        @endif
                    </div>

                    {{-- BASIC INFO --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">MSSV</label>
                            <div class="p-2 bg-light rounded border">{{ $register->student_code }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Họ Tên</label>
                            <div class="p-2 bg-light rounded border">{{ $register->full_name }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Giới Tính</label>
                            <div class="p-2 bg-light rounded border text-capitalize">{{ method_exists($register, 'gender_label') ? $register->gender_label : ($register->gender ?? '—') }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Số Điện Thoại</label>
                            <div class="p-2 bg-light rounded border">{{ $register->phone ?? 'N/A' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Ngày Nộp</label>
                            <div class="p-2 bg-light rounded border">
                                {{ \Carbon\Carbon::parse($register->created_at)->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        @if ($register->approved_at)
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Ngày Duyệt</label>
                                <div class="p-2 bg-light rounded border">
                                    {{ \Carbon\Carbon::parse($register->approved_at)->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- PRIORITY --}}
                    @if ($register->priority)
                        <div class="alert alert-info mt-4">
                            <strong>🎯 Mức ưu tiên:</strong> {{ $register->priority->priority_name }}
                            @if ($register->priority->description)
                                <div class="text-muted mt-1">{{ $register->priority->description }}</div>
                            @endif
                        </div>
                    @endif

                    {{-- NOTE --}}
                    @if ($register->note)
                        <div class="alert alert-secondary mt-3">
                            <strong>📌 Ghi chú:</strong> {{ $register->note }}
                        </div>
                    @endif

                    {{-- REJECTED REASON --}}
                    @if ($register->status === 'rejected' && $register->rejected_reason)
                        <div class="alert alert-danger mt-3">
                            <strong>❌ Lý do từ chối:</strong> {{ $register->rejected_reason }}
                        </div>
                    @endif

                    {{-- TIMELINE --}}
                    <hr class="my-4">
                    <h5 class="fw-bold mb-3">⏱ Tiến Trình Xử Lý</h5>

                    <ul class="timeline">
                        <li class="timeline-item">
                            <strong>📥 Nộp hồ sơ</strong>
                            <div class="text-muted small">{{ \Carbon\Carbon::parse($register->created_at)->format('d/m/Y H:i') }}</div>
                        </li>

                        <li class="timeline-item">
                            <strong>🔍 Đang xử lý</strong>
                            <div class="text-muted small">Hồ sơ đang được kiểm duyệt bởi quản trị viên</div>
                        </li>

                        @if ($register->status !== 'pending')
                            <li class="timeline-item">
                                <strong>
                                    @if ($register->status === 'approved')
                                        ✔ Được duyệt
                                    @else
                                        ✘ Bị từ chối
                                    @endif
                                </strong>

                                @if ($register->approved_at)
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($register->approved_at)->format('d/m/Y H:i') }}
                                    </div>
                                @endif
                            </li>
                        @endif
                    </ul>

                </div>
            </div>
        @endif

    </div>
</div>

{{-- TIMELINE CSS --}}
<style>
.timeline {
    border-left: 3px solid #ddd;
    margin-left: 15px;
    padding-left: 20px;
}
.timeline-item {
    margin-bottom: 20px;
    position: relative;
}
.timeline-item::before {
    content: "";
    width: 12px;
    height: 12px;
    background: #0d6efd;
    border-radius: 50%;
    position: absolute;
    left: -27px;
    top: 3px;
}
</style>

@endsection
