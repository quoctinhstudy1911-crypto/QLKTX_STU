@extends('student.layouts.app')

@section('title', 'Hồ Sơ Cá Nhân')

@section('content')

<div class="row">
    <div class="col-md-8 col-lg-6 mx-auto">
        {{-- HEADER --}}
        <div class="mb-4">
            <h1 class="h3 mb-2">Hồ Sơ Cá Nhân</h1>
            <p class="text-muted">Xem và cập nhật thông tin cá nhân của bạn</p>
        </div>

        {{-- ALERTS --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Lỗi:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- CARD --}}
        <div class="card shadow-sm">
            <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                @csrf

                {{-- AVATAR HEADER --}}
                <div class="card-header text-center bg-primary text-white py-4">
                    <div class="d-flex justify-content-center mb-3">
                        <img src="{{ $profile->avatar ? route('avatar.serve', $profile->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($profile->full_name) . '&background=0D8ABC&color=fff&size=150' }}"
                             class="rounded-circle img-thumbnail border-3 shadow"
                             width="120" height="120" alt="Avatar">
                    </div>

                    <h4 class="mb-0 fw-bold">{{ $profile->full_name }}</h4>
                    <div class="text-white-50">MSSV: {{ $profile->student_code }}</div>
                </div>

                {{-- BODY FORM --}}
                <div class="card-body">

                    {{-- GRID 2 COL --}}
                    <div class="row g-3">

                        {{-- Không cho sửa --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Họ Tên</label>
                            <input class="form-control" value="{{ $profile->full_name }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">MSSV</label>
                            <input class="form-control" value="{{ $profile->student_code }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Lớp</label>
                            <input class="form-control" value="{{ $studentOfficial->class_name }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Khoa</label>
                            <input class="form-control" value="{{ $studentOfficial->department }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ngày Sinh</label>
                            <input class="form-control"
                                   value="{{ $profile->dob ? \Carbon\Carbon::parse($profile->dob)->format('d/m/Y') : 'N/A' }}"
                                   disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Giới Tính</label>
                            <input class="form-control" value="{{ method_exists($profile, 'gender_label') ? $profile->gender_label : ($profile->gender ?? '—') }}" disabled>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Quê Quán</label>
                            <input type="text" name="hometown" class="form-control" value="{{ old('hometown', $profile->hometown) }}">
                        </div>

                        {{-- Editable fields --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Số Điện Thoại *</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Địa Chỉ</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $profile->address) }}</textarea>
                        </div>

                        {{-- Upload Avatar --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Ảnh Đại Diện</label>
                            <input type="file" name="avatar" class="form-control"
                                   accept="image/png,image/jpeg,image/jpg">
                        </div>

                    </div> <!-- row -->

                </div> <!-- card-body -->

                {{-- FOOTER --}}
                <div class="card-footer text-end">
                    <button class="btn btn-primary px-4">
                        <i class="align-middle me-1" data-feather="save"></i> Cập Nhật Hồ Sơ
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
