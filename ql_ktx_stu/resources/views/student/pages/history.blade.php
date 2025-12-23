@extends('student.layouts.app')

@section('title', 'Lịch Sử Lưu Trú')

@section('content')

<div class="row">
    <div class="col-lg-10 mx-auto">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="h3">📋 Lịch Sử Lưu Trú</h1>
            <p class="text-muted">Danh sách toàn bộ các lần bạn đã ở KTX</p>
        </div>

        @if ($records->count() > 0)

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Lịch sử ở cư xá</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Phòng</th>
                                <th>Giường</th>
                                <th>Học kỳ</th>
                                <th>Bắt đầu</th>
                                <th>Kết thúc</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($records as $record)
                            <tr>
                                {{-- Phòng --}}
                                <td>
                                    <span class=" text-black badge bg-primary">
                                        {{ $record->room->room_number ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Giường --}}
                                <td>
                                    Giường <strong>{{ $record->bed->bed_code ?? 'N/A' }}</strong>
                                </td>

                                {{-- Học kỳ --}}
                                <td>
                                    {{ $record->hocKy->school_year ?? 'N/A' }}
                                    – Kỳ {{ $record->hocKy->semester ?? 'N/A' }}
                                </td>

                                {{-- Bắt đầu --}}
                                <td>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($record->check_in_date)->format('d/m/Y') }}
                                    </strong>
                                </td>

                                {{-- Kết thúc --}}
                                <td>
                                    @if ($record->check_out_date)
                                        <strong>
                                            {{ \Carbon\Carbon::parse($record->check_out_date)->format('d/m/Y') }}
                                        </strong>
                                    @else
                                        <span class="text-muted fst-italic">Chưa xác định</span>
                                    @endif
                                </td>

                                {{-- Trạng thái --}}
                                <td>
                                    @if ($record->is_active)
                                        <span class="text-black badge bg-success">✓ Đang ở</span>
                                    @else
                                        <span class="text-black badge bg-secondary">Đã rời</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- Lý do rời (nếu có) --}}
                            @if ($record->reason_leave)
                                <tr class="table-warning">
                                    <td colspan="6">
                                        <strong>📝 Lý do rời:</strong>
                                        <span class="ms-2">{{ $record->reason_leave }}</span>
                                    </td>
                                </tr>
                            @endif

                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="card-footer text-center">
                    {{ $records->links('pagination::bootstrap-5') }}
                </div>
            </div>

        @else
            {{-- Empty State --}}
            <div class="card shadow-sm p-5 text-center">
                <div class="display-1 text-muted mb-3">📋</div>
                <h3 class="mb-2">Chưa có lịch sử lưu trú</h3>
                <p class="text-muted mb-0">Bạn chưa có bất kỳ bản ghi lưu trú nào.</p>
            </div>
        @endif

    </div>
</div>

@endsection
