<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - KTX STU</title>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>

<body>
<main class="d-flex w-100 h-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Khôi phục mật khẩu</h1>
                        <p class="lead">
                            Nhập email để nhận link đặt lại mật khẩu
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">

                                @if (session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                               placeholder="name@example.com" required>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn btn-lg btn-primary w-100">
                                            Gửi email đặt lại mật khẩu
                                        </button>
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="/login">Quay lại đăng nhập</a>
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
