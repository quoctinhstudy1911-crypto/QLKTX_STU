@extends('admin.layouts.master')
@section('title', 'Danh sách hồ sơ đăng ký')

@section('content')

<h1 class="h3 mb-3">Danh sách hồ sơ đăng ký</h1>

<div class="card">
    <div class="card-body">

        {{-- FILTER TRẠNG THÁI --}}
        <form method="GET" class="row mb-3">
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="pending"  {{ request('status')=='pending' ? 'selected':'' }}>Đang chờ</option>
                    <option value="approved" {{ request('status')=='approved' ? 'selected':'' }}>Đã duyệt</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected':'' }}>Đã từ chối</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary">Lọc</button>
            </div>
        </form>

        {{-- TABLE --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã SV</th>
                    <th>Họ tên</th>
                    <th>Ưu tiên</th>
                    <th>Trạng thái</th>
                    <th>Ngày gửi</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($requests as $req)
                    <tr>
                        <td>{{ $req->student_code }}</td>
                        <td>{{ $req->full_name }}</td>

                        <td>{{ optional($req->priority)->name ?? '—' }}</td>

                        <td>
                           @if($req->status == 'pending')
                            <span class="badge bg-warning text-dark">Đang chờ</span>
                        @elseif($req->status == 'approved')
                            <span class="badge bg-primary text-white">Đã duyệt</span>
                        @else
                            <span class="badge bg-danger text-white">Từ chối</span>
                        @endif
                        </td>

                        <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>

                        <td>
                            <a href="{{ route('admin.register.show', $req->id) }}"
                               class="btn btn-sm btn-primary">
                                Xem
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Không có hồ sơ nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $requests->links('vendor.pagination.custom') }}
        </div>

    </div>
</div>

@endsection
