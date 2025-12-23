@extends('admin.layouts.master')
@section('title', 'Sinh viên lưu trú')

@section('content')
<h1 class="h3 mb-3"><strong>Sinh viên lưu trú</strong></h1>

<div class="card shadow-sm">
    <div class="card-body">

        {{-- ======================= FILTER ======================== --}}
        <form method="GET" class="row g-2 mb-4">

            <div class="col-md-3">
                <input type="text" name="q" class="form-control"
                       placeholder="Tìm mã SV hoặc họ tên..."
                       value="{{ request('q') }}">
            </div>

            <div class="col-md-2">
                <select name="gender" class="form-select">
                    <option value="">Giới tính</option>
                    <option value="{{ \App\Models\Room::genderMale() }}"   {{ request('gender')==\App\Models\Room::genderMale() ? 'selected':'' }}>Nam</option>
                    <option value="{{ \App\Models\Room::genderFemale() }}" {{ request('gender')==\App\Models\Room::genderFemale() ? 'selected':'' }}>Nữ</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="room_id" class="form-select">
                    <option value="">Phòng</option>
                    @foreach($rooms as $r)
                        <option value="{{ $r->id }}" {{ request('room_id')==$r->id ? 'selected':'' }}>
                            {{ $r->room_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="hoc_ky_id" class="form-select">
                    <option value="">Học kỳ</option>
                    @foreach($hocKys as $hk)
                        <option value="{{ $hk->id }}" {{ request('hoc_ky_id')==$hk->id ? 'selected':'' }}>
                            {{ $hk->school_year }} - HK{{ $hk->semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 text-end">
                <button class="btn btn-primary">Lọc</button>
                <a href="{{ route('admin.residents.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>

        </form>

        {{-- ======================= TABLE ======================== --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Sinh viên</th>
                        <th>Phòng</th>
                        <th>Giường</th>
                        <th>Check-in</th>
                        <th>Trạng thái</th>
                        <th style="width: 140px">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $rec)
                    <tr>

                        {{-- CỘT SINH VIÊN --}}
                        <td>
                        <div class="fw-bold text-dark" style="font-size: 15px;">
                            {{ $rec->user?->profile?->full_name ?? 'Không rõ tên' }}
                        </div>

                        <div class="small text-dark" style="opacity: 0.85;">
                            <span class="me-2">
                                <i class="bi bi-person-badge me-1"></i>
                                {{ $rec->user?->profile?->student_code ?? '—' }}
                            </span>

                            <span class="me-2">
                                <i class="bi bi-gender-ambiguous me-1"></i>
                                {{
                                    $rec->user?->profile?->gender_label
                                    ?? $rec->user?->profile?->gender
                                    ?? '—'
                                }}
                            </span>

                            <span>
                                <i class="bi bi-building me-1"></i>
                                {{ $rec->user?->profile?->department ?? '—' }}
                            </span>
                        </div>
                    </td>

                        {{-- PHÒNG – GIƯỜNG --}}
                        <td>{{ $rec->room->room_number ?? '—' }}</td>
                        <td>{{ $rec->bed->bed_code ?? '—' }}</td>

                        {{-- NGÀY CHECK-IN --}}
                        <td>{{ $rec->check_in_date }}</td>

                        {{-- TRẠNG THÁI --}}
                        <td>
                           <span class="badge rounded-pill {{ $rec->is_active ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                                {{ $rec->is_active ? 'Đang ở' : 'Đã rời' }}
                            </span>
                        </td>

                        {{-- THAO TÁC --}}
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    Thao tác
                                </button>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                           data-bs-toggle="modal"
                                           data-bs-target="#changeRoomModal"
                                           data-record-id="{{ $rec->id }}"
                                           data-room-id="{{ $rec->room_id }}">
                                           Chuyển phòng
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           data-bs-toggle="modal"
                                           data-bs-target="#extendModal"
                                           data-record-id="{{ $rec->id }}">
                                           Gia hạn
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item text-danger"
                                           data-bs-toggle="modal"
                                           data-bs-target="#checkoutModal"
                                           data-record-id="{{ $rec->id }}">
                                           Trả phòng
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.residents.history', $rec->user_id) }}">
                                           Lịch sử
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Không có sinh viên.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $records->links('vendor.pagination.custom') }}
        </div>

    </div>
</div>

@include('admin.pages.residents.partials.modals', ['roomBedMap' => $roomBedMap])
@endsection
