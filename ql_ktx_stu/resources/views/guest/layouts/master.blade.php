<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'KTX STU')</title>

    {{-- AdminKit CSS --}}
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body>
<div class="wrapper">

    {{-- SIDEBAR --}}
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">

            <a class="sidebar-brand" href="{{ route('guest.home') }}">
                <span class="align-middle">KTX STU</span>
            </a>

            <ul class="sidebar-nav">

                <li class="sidebar-header">Menu</li>

                <li class="sidebar-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('guest.home') }}">
                        <i class="align-middle" data-feather="home"></i>
                        <span class="align-middle">Trang chủ</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('register') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('guest.register') }}">
                        <i class="align-middle" data-feather="edit"></i>
                        <span class="align-middle">Đăng ký nội trú</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('register/status') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('guest.status') }}">
                        <i class="align-middle" data-feather="search"></i>
                        <span class="align-middle">Tra cứu trạng thái</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('guide') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('guest.guide') }}">
                        <i class="align-middle" data-feather="book-open"></i>
                        <span class="align-middle">Hướng dẫn</span>
                    </a>
                </li>
            </ul>

        </div>
    </nav>

    {{-- MAIN WRAPPER --}}
    <div class="main">

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <a class="sidebar-toggle js-sidebar-toggle">
                <i class="hamburger align-self-center"></i>
            </a>

            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">

                    {{-- BUTTON LOGIN --}}
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="{{ route('login') }}">
                            <i class="align-middle" data-feather="log-in"></i>
                            Đăng nhập
                        </a>
                    </li>

                </ul>
            </div>
        </nav>

        {{-- MAIN CONTENT --}}
        <main class="content">
            <div class="container-fluid p-0">

                @yield('content')

            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <p class="mb-0">
                            <strong>KTX STU</strong> &copy; 2025
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <span class="text-muted">Hệ thống đăng ký nội trú</span>
                    </div>
                </div>
            </div>
        </footer>

    </div> {{-- END MAIN --}}
</div> {{-- END WRAPPER --}}

{{-- JS AdminKit --}}
<script src="{{ asset('assets/js/app.js') }}"></script>

{{-- Feather Icons --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();
    });
</script>

@stack('scripts')
</body>
</html>
