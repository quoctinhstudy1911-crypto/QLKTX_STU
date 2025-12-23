<!DOCTYPE html>
<html lang="en">
    <style>
       
    </style>

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - KTX STU</title>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100 h-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h1">Ký túc xá STU</h1>
                            <p class="h3">Đăng nhập hệ thống</p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">

                                    @if ($errors->any())
                                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                                    @endif
                            <div class="m-sm-4 login-form">
                                  <form method="POST" action="/login">
                                        @csrf

                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                placeholder="name@example.com" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Mật khẩu</label>
                                            <input type="password" name="password" class="form-control form-control-lg"
                                                placeholder="••••••" required>
                                        </div>

                                        <div class="text-center mt-3">
                                            <button class="btn btn-lg btn-primary w-100">Đăng nhập</button>
                                        </div>

                                        <div class="text-center mt-3">
                                            <a href="/forgot-password">Quên mật khẩu?</a>
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
        </div>
    </main>

<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
