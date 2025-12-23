@extends('student.layouts.app')

@section('title', 'Đổi Mật Khẩu')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">

        <h1 class="h3 mb-3">🔐 Đổi Mật Khẩu</h1>
        <p class="text-muted mb-4">Cập nhật mật khẩu đăng nhập tài khoản cư xá của bạn.</p>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <h5 class="fw-bold">⚠ Lỗi xảy ra:</h5>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('student.password.update') }}">
                    @csrf

                    {{-- CURRENT PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mật khẩu hiện tại *</label>
                        <input type="password" 
                               name="current_password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               placeholder="Nhập mật khẩu hiện tại" 
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NEW PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mật khẩu mới *</label>
                        <input type="password" 
                               name="password" 
                               minlength="8"
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Nhập mật khẩu mới" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SECURITY HINT --}}
                    <div class="alert alert-info small">
                        <strong>💡 Gợi ý mật khẩu mạnh:</strong>
                        <ul class="mb-0 ps-3">
                            <li>Ít nhất 8 ký tự</li>
                            <li>Có chữ hoa, chữ thường, số & ký tự đặc biệt</li>
                            <li>Không dùng tên, ngày sinh, MSSV</li>
                            <li>Không chia sẻ với người khác</li>
                        </ul>
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Xác nhận mật khẩu *</label>
                        <input type="password" 
                               name="password_confirmation" 
                               minlength="8"
                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                               placeholder="Nhập lại mật khẩu" 
                               required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <button class="btn btn-primary w-100 py-2 fw-bold">
                        Cập Nhật Mật Khẩu
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
