@extends('admin.layouts.master')
@section('title', 'Quản lý giường')

@section('content')

<h1 class="h3 mb-3"><strong>Quản lý giường</strong></h1>

<div class="card">
    <div class="card-body">

        {{-- FILTER --}}
        <form method="GET" class="row mb-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">Lọc theo phòng</label>
                <select class="form-control" name="room_id">
                    <option value="">-- Tất cả phòng --</option>

                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ $roomId == $room->id ? 'selected' : '' }}>
                            Phòng {{ $room->room_number }} ({{ $room->gender_label }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Lọc</button>
            </div>

            <div class="col-md-6 text-end">
                <a href="{{ route('admin.beds.create') }}" class="btn btn-success">
                    + Thêm giường
                </a>
            </div>
        </form>

        {{-- TABLE --}}
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Mã giường</th>
                    <th>Phòng</th>
                    <th>Giới tính</th>
                    <th>Trạng thái</th>
                    <th width="140">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($beds as $bed)
                <tr>

                    <td><strong>{{ $bed->bed_code }}</strong></td>

                    <td>
                        @if($bed->room)
                            Phòng {{ $bed->room->room_number }}
                        @else
                            <span class="text-danger">— Không có —</span>
                        @endif
                    </td>

                    <td>
                        {{ $bed->room ? $bed->room->gender_label : '—' }}
                    </td>

                    

<td>
    @php
    $colors = [
        'available'   => 'primary',   // xanh dương
        'occupied'    => 'warning',   // vàng
        'maintenance' => 'danger'     // đỏ
    ];
@endphp
    <span class="badge bg-{{ $colors[$bed->status] ?? 'secondary' }} text-white">
        {{ ucfirst($bed->status) }}
    </span>
</td>

                    <td>
                        <a href="{{ route('admin.beds.edit', $bed) }}" 
                           class="btn btn-warning btn-sm">
                            Sửa
                        </a>

                        <form action="{{ route('admin.beds.destroy', $bed) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Xóa giường này?')"
                                    class="btn btn-danger btn-sm">
                                Xóa
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Không có dữ liệu</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
             {{ $beds->links('vendor.pagination.custom') }}
        </div>

    </div>
</div>

@endsection
