@extends('guest.layouts.master')

@section('title', 'Đăng ký nội trú')

@section('content')

<div class="card shadow-sm p-4">

    <h3 class="fw-bold mb-3">
        📝 Đăng ký nhu cầu lưu trú KTX STU
    </h3>

    <p class="text-muted mb-4">
        Vui lòng điền đầy đủ thông tin bên dưới để hệ thống ghi nhận nhu cầu đăng ký KTX.
    </p>

    {{-- =========================
        THÔNG BÁO TRẠNG THÁI
    ============================ --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Hiển thị tất cả lỗi validate --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Vui lòng kiểm tra lại thông tin!</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- =========================
        FORM ĐĂNG KÝ
    ============================ --}}
    <form method="POST" action="{{ route('guest.register.submit') }}" class="row g-3">
        @csrf

        {{-- HỌ TÊN --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Họ tên *</label>
            <input type="text" name="full_name"
                   class="form-control @error('full_name') is-invalid @enderror"
                   placeholder="Nhập họ tên đầy đủ"
                   value="{{ old('full_name') }}" required>
            @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- MSSV --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Mã sinh viên (MSSV) *</label>
            <input type="text" name="student_code"
                   class="form-control @error('student_code') is-invalid @enderror"
                   placeholder="VD: DH52201580"
                   value="{{ old('student_code') }}" required>

            {{-- LỖI VALIDATE --}}
            @error('student_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- LỖI MSSV KHÔNG TỒN TẠI --}}
            @if(session('error'))
                <div class="text-danger small mt-1">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- SỐ ĐIỆN THOẠI --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Số điện thoại</label>
            <input type="text" name="phone" class="form-control"
                   placeholder="VD: 0987654321"
                   value="{{ old('phone') }}">
        </div>

        {{-- ĐỊA CHỈ --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Địa chỉ</label>
            <input type="text" name="address" class="form-control"
                   placeholder="Nhập địa chỉ hiện tại"
                   value="{{ old('address') }}">
        </div>

        {{-- LÝ DO --}}
        <div class="col-12">
            <label class="form-label fw-semibold">Lý do (không bắt buộc)</label>
            <textarea name="reason" class="form-control" rows="2"
                      placeholder="Lý do đăng ký…">{{ old('reason') }}</textarea>
        </div>

        {{-- MỨC ĐỘ ƯU TIÊN --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Mức độ ưu tiên</label>
            <select name="priority_level_id" class="form-select">
                <option value="">-- Không có --</option>
                @foreach($priorities as $p)
                    <option value="{{ $p->id }}"
                        {{ old('priority_level_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }} (Điểm: {{ $p->score }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- NÚT GỬI --}}
        <div class="col-12 mt-4">
            <button class="btn btn-primary px-4">📨 Gửi đăng ký</button>
        </div>

    </form>

</div>

@endsection
