@extends('student.layouts.app')

@section('title', 'Thông tin phòng - giường')

@section('content')

<div class="row">
    <div class="col-md-10 col-lg-9 mx-auto">

        {{-- HEADER --}}
        <div class="mb-4">
            <h1 class="h3 mb-1">Thông Tin Phòng & Giường</h1>
            <p class="text-muted mb-0">Thông tin lưu trú hiện tại của sinh viên</p>
        </div>

        @if (!$record)
            <div class="alert alert-warning">
                ⚠️ Bạn chưa được xếp phòng. Vui lòng chờ quản trị viên xử lý.
            </div>
        @else

        <div class="card shadow-sm mb-4">

           
            {{-- CARD BODY --}}
            <div class="card-body">

                <div class="row g-3">

                    {{-- ================= PHÒNG ================= --}}
                    <div class="col-12 mt-2">
                        <h6 class="text-primary fw-bold mb-2">Thông tin phòng</h6>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Số phòng</small>
                            <div class="value fs-5">{{ $record->room->room_number }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Loại phòng</small>
                            <div class="value">{{ $record->room->room_type ?? 'Chưa cập nhật' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Sức chứa</small>
                            <div class="value">{{ $record->room->capacity }} người</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Giới tính phòng</small>
                            <div class="value">
                                {{ $record->room->gender === 'male' ? 'Nam' : 'Nữ' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Tầng</small>
                            <div class="value">{{ $record->room->floor ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Diện tích</small>
                            <div class="value">
                                {{ $record->room->area ? $record->room->area . ' m²' : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    {{-- ================= GIƯỜNG ================= --}}
                    <div class="col-12 mt-4">
                        <h6 class="text-primary fw-bold mb-2">Thông tin giường</h6>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Số giường</small>
                            <div class="value fs-5">{{ $record->bed->bed_code }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Trạng thái giường</small>
                            <div class="value text-success">
                                {{ ucfirst($record->bed->status) }}
                            </div>
                        </div>
                    </div>

                    @if ($record->bed->note)
                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Ghi chú giường</small>
                            <div class="value">{{ $record->bed->note }}</div>
                        </div>
                    </div>
                    @endif

                    {{-- ================= THỜI GIAN ================= --}}
                    <div class="col-12 mt-4">
                        <h6 class="text-primary fw-bold mb-2">Thời gian lưu trú</h6>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Từ ngày</small>
                            <div class="value">
                                {{ \Carbon\Carbon::parse($record->check_in_date)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Đến ngày</small>
                            <div class="value">
                                {{ $record->check_out_date
                                    ? \Carbon\Carbon::parse($record->check_out_date)->format('d/m/Y')
                                    : 'Chưa xác định' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <small>Mã thẻ cư xá</small>
                            <div class="value text-primary">
                                {{ $record->card_number ?? 'Chưa cấp' }}
                            </div>
                        </div>
                    </div>

                    {{-- ================= HỌC KỲ ================= --}}
                    <div class="col-12 mt-4">
                        <h6 class="text-primary fw-bold mb-2">Học kỳ</h6>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <small>Học kỳ</small>
                            <div class="value">{{ $record->hocKy->semester }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <small>Năm học</small>
                            <div class="value">{{ $record->hocKy->school_year }}</div>
                        </div>
                    </div>

                </div>

                {{-- STATUS --}}
                <div class="mt-4 pt-3 border-top text-end">
                    <span class="badge {{ $record->is_active ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                        {{ $record->is_active ? 'Đang lưu trú' : 'Đã kết thúc lưu trú' }}
                    </span>
                </div>

            </div>
        </div>
        @endif

    </div>
</div>

@endsection
