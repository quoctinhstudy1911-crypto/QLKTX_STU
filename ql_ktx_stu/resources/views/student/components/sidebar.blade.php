<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('student.dashboard') }}">
            <span class="align-middle">🏠 KTX Sinh Viên</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Tài Khoản Của Tôi
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('student.dashboard') }}">
                    <i class="align-middle" data-feather="home"></i> 
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('student.profile') }}">
                    <i class="align-middle" data-feather="user"></i> 
                    <span class="align-middle">Hồ Sơ Cá Nhân</span>
                </a>
            </li>

            <li class="sidebar-header">
                Ký Túc Xá
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('student.room') }}">
                    <i class="align-middle" data-feather="grid"></i>
                    <span class="align-middle">Phòng Hiện Tại</span>
                </a>
            </li>

            <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('student.history') }}">
                    <i class="align-middle" data-feather="book"></i> 
                    <span class="align-middle">Lịch Sử Lưu Trú</span>
                </a>
            </li>

            <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('student.registration.status') }}">
                    <i class="align-middle" data-feather="file-text"></i> 
                    <span class="align-middle">Trạng Thái Đăng Ký</span>
                </a>
            </li>

            <li class="sidebar-header">
                Bảo Mật
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('student.password') }}">
                    <i class="align-middle" data-feather="lock"></i> 
                    <span class="align-middle">Đổi Mật Khẩu</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
