<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu - KTX STU</title>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>

<body>
<main class="d-flex w-100 h-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Đặt lại mật khẩu</h1>
                        <p class="lead">
                            Nhập mật khẩu mới cho tài khoản của bạn
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">

                                @if ($errors->any())
                                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                                @endif

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email"
                                         value="{{ $email ?? old('email') }}"
                                         class="form-control" readonly>

                                    <div class="mb-3">
                                        <label>Mật khẩu mới</label>
                                        <input type="password" name="password" class="form-control"
                                               placeholder="••••••" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Nhập lại mật khẩu</label>
                                        <input type="password" name="password_confirmation"
                                               class="form-control" placeholder="••••••" required>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn btn-lg btn-primary w-100">
                                            Đặt lại mật khẩu
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-3">
                        <small>© 2025 KTX STU</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
