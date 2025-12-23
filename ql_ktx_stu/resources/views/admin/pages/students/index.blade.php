@extends('admin.layouts.app')
@section('title', 'Danh Sách Sinh Viên')

@section('content')

{{-- ======================= PAGINATION CSS ======================= --}}
<style>
.pagination-info {
    font-size: 14px;
    color: #6c757d;
    text-align: center;
    margin-top: 12px;
}

/* Pagination container */
.pagination {
    display: flex !important;
    justify-content: center !important;
    gap: 6px !important;
    padding: 10px 0;
}

/* Default pagination button */
.pagination .page-link {
    border: 1px solid #dcdcdc !important;
    padding: 6px 12px !important;
    border-radius: 8px !important;
    color: #495057 !important;
    background: #fff !important;
}

/* Hover */
.pagination .page-link:hover {
    background: #f0f0f0 !important;
}

/* Active */
.pagination .active .page-link {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    color: #ffffff !important;
    box-shadow: 0 0 6px rgba(13, 110, 253, 0.4);
}

/* Disabled */
.pagination .disabled .page-link {
    opacity: 0.4;
    pointer-events: none;
}
</style>

<div class="container-fluid px-4">

    <div class="row justify-content-center">
        <div class="col-xl-12">

            <div class="card shadow-sm border-0">

                {{-- ================= HEADER ================= --}}
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i data-feather="users" class="me-2"></i>
                        Danh Sách Sinh Viên Chính Thức
                    </h3>

                   
                </div>

                {{-- ================= BODY ================= --}}
                <div class="card-body">

                    {{-- SUCCESS MESSAGE --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i data-feather="check-circle" class="me-1"></i>
                            <strong>Thành công!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- ERROR MESSAGE --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i data-feather="alert-octagon" class="me-1"></i>
                            <strong>Lỗi!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif


                    {{-- ================= TABLE ================= --}}
                    @if ($students->count())

                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-bordered align-middle">

                                <thead class="table-light">
                                    <tr>
                                        <th width="60">#</th>
                                        <th>Mã SV</th>
                                        <th>Họ & Tên</th>
                                        <th>Giới Tính</th>
                                        <th>Khoa</th>
                                        <th>Lớp</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            {{-- STT --}}
                                            <td class="text-center fw-bold">
                                                {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                                            </td>

                                            {{-- MSSV --}}
                                            <td class="fw-bold text-primary">{{ $student->student_code }}</td>

                                            {{-- Họ tên --}}
                                            <td>{{ $student->full_name }}</td>

                                            {{-- Giới tính --}}
                                            <td>
                                                @if ($student->isMale())
                                                    <span class="badge bg-primary-subtle text-dark">Nam</span>
                                                @elseif ($student->isFemale())
                                                    <span class="badge bg-danger-subtle text-dark">Nữ</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-dark">N/A</span>
                                                @endif
                                            </td>

                                            <td>{{ $student->department ?? 'N/A' }}</td>
                                            <td>{{ $student->class_name ?? 'N/A' }}</td>
                                            <td>{{ $student->email ?? 'N/A' }}</td>

                                          
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        {{-- INFO TEXT --}}
                        <div class="pagination-info">
                            Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
                        </div>

                        {{-- PAGINATION --}}
                        <div>
                            {{ $students->onEachSide(1)->links('vendor.pagination.custom') }}
                        </div>

                    @else
                        <div class="alert alert-info mt-3">
                            <i data-feather="info" class="me-1"></i>
                            Không có dữ liệu sinh viên.
                            <a href="{{ route('admin.students.import') }}" class="fw-bold">Import ngay</a>.
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

</div>

@endsection
