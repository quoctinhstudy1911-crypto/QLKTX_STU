@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold">Thống kê tổng quan</h3>
</div>

{{-- ======================== ROW 1: BIG STATS ======================== --}}
<div class="row g-3">

    {{-- Tổng Phòng --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-primary text-white">
            <div class="card-body py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-black-50 mb-1">Tổng Phòng</p>
                        <h2 class="fw-bold">{{ $totalRooms }}</h2>
                    </div>
                    <i data-feather="home" class="icon-lg opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Giường Trống --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-success text-white">
            <div class="card-body py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-black-50 mb-1">Giường Trống</p>
                        <h2 class="fw-bold">{{ $availableBeds }}/{{ $totalBeds }}</h2>
                    </div>
                    <i data-feather="bed" class="icon-lg opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Sinh viên đang ở --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-info text-white">
            <div class="card-body py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-black-50 mb-1">Sinh Viên Đang Ở</p>
                        <h2 class="fw-bold">{{ $totalStudentsLiving }}</h2>
                    </div>
                    <i data-feather="users" class="icon-lg opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Đơn chờ duyệt --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-warning text-white">
            <div class="card-body py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-black-50 mb-1">Đơn Chờ Duyệt</p>
                        <h2 class="fw-bold">{{ $pendingRequests }}</h2>
                    </div>
                    <i data-feather="clock" class="icon-lg opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ======================== ROW 2: MINI STATS ======================== --}}
<div class="row mt-4 g-3">

    <div class="col-md-2">
        <div class="card shadow-sm border-0 text-center py-3">
            <h6 class="text-muted">Sinh Viên Chính Thức</h6>
            <h3 class="text-primary fw-bold">{{ $totalStudentsOfficial }}</h3>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card shadow-sm border-0 text-center py-3">
            <h6 class="text-muted">Tổng User</h6>
            <h3 class="text-info fw-bold">{{ $totalUsers }}</h3>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card shadow-sm border-0 text-center py-3">
            <h6 class="text-muted">Đơn Đã Duyệt</h6>
            <h3 class="text-success fw-bold">{{ $approvedRequests }}</h3>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card shadow-sm border-0 text-center py-3">
            <h6 class="text-muted">Đơn Bị Từ Chối</h6>
            <h3 class="text-danger fw-bold">{{ $rejectedRequests }}</h3>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card shadow-sm border-0 text-center py-3">
            <h6 class="text-muted">Tổng Giường</h6>
            <h3 class="text-secondary fw-bold">{{ $totalBeds }}</h3>
        </div>
    </div>

</div>

{{-- ======================== ROW 3: TABLES ======================== --}}
<div class="row mt-4 g-3">

    {{-- Occupancy --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold">Độ Kín Các Phòng</div>
            <div class="card-body">

                @if ($roomOccupancy->count() > 0)
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Phòng</th>
                                <th>Sức chứa</th>
                                <th>Đang dùng</th>
                                <th>Độ kín (%)</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($roomOccupancy as $room)
                                <tr>
                                    <td><strong>{{ $room['room_number'] }}</strong></td>
                                    <td>{{ $room['capacity'] }}</td>
                                    <td>{{ $room['occupied'] }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $color = $room['occupancy_rate'] >= 80
                                                    ? 'bg-danger'
                                                    : ($room['occupancy_rate'] >= 50 ? 'bg-warning' : 'bg-success');
                                            @endphp
                                            <div class="progress-bar {{ $color }}" style="width: {{ $room['occupancy_rate'] }}%">
                                                {{ $room['occupancy_rate'] }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <p class="text-muted">Không có dữ liệu</p>
                @endif

            </div>
        </div>
    </div>

    {{-- Bed status --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold">Trạng Thái Giường</div>
            <div class="card-body">

                @if ($bedsByStatus->count() > 0)
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Trạng thái</th>
                                <th>Số lượng</th>
                                <th>Tỉ lệ (%)</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $total = $bedsByStatus->sum('count'); @endphp
                            @foreach ($bedsByStatus as $status)
                                <tr>
                                    <td>
                                        @if ($status->status == 'available')
                                            <span class="text-black badge bg-success">Sẵn</span>
                                        @elseif ($status->status == 'occupied')
                                            <span class="text-black badge bg-danger">Đã dùng</span>
                                        @else
                                            <span class="text-black badge bg-secondary">{{ $status->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $status->count }}</td>
                                    <td>
                                        @php $percent = round(($status->count / $total) * 100, 1); @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" style="width: {{ $percent }}%">
                                                {{ $percent }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <p class="text-muted">Không có dữ liệu</p>
                @endif

            </div>
        </div>
    </div>

</div>

{{-- ======================== ROW 4: RECENT ======================== --}}
<div class="row mt-4 g-3">

    {{-- Recent residents --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold">Sinh Viên Lưu Trú Gần Đây</div>
            <div class="card-body">

                @if ($recentResidents->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach ($recentResidents as $resident)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $resident->profile->full_name ?? 'N/A' }}</h6>
                                    <small class="text-muted">
                                        Phòng {{ $resident->room->room_number ?? 'N/A' }} —
                                        Giường {{ $resident->bed->bed_code ?? 'N/A' }}
                                    </small>
                                </div>
                                <small class="text-muted">
                                    {{ optional($resident->check_in_date)->format('d/m/Y') }}
                                </small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Không có dữ liệu</p>
                @endif

            </div>
        </div>
    </div>

    {{-- Pending Requests --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
                <span>Đơn Chờ Duyệt</span>
                @if ($pendingRequests > 0)
                    <a href="{{ route('admin.register.index') }}" class="btn btn-primary btn-sm">
                        Xem tất cả
                    </a>
                @endif
            </div>

            <div class="card-body">

                @if ($pendingRegisterRequests->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach ($pendingRegisterRequests as $req)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $req->student->full_name ?? 'N/A' }}</h6>
                                    <small class="text-muted">{{ $req->student->student_code ?? 'N/A' }}</small>
                                </div>
                                <span class="badge bg-warning text-dark">Chờ duyệt</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Không có đơn chờ duyệt</p>
                @endif

            </div>
        </div>
    </div>

</div>

@endsection
