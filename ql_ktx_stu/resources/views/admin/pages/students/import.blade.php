@extends('admin.layouts.app')

@section('title', 'Import Sinh Viên')

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-9">

        <div class="card shadow-sm border-0">
            
            {{-- HEADER --}}
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <h4 class="mb-0">
                    <i data-feather="upload-cloud" class="me-2"></i>
                    Import Sinh Viên Từ CSV
                </h4>
            </div>

            <div class="card-body">

                {{-- SUCCESS --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i data-feather="check-circle" class="me-2"></i>
                        <strong>Thành công:</strong> {{ $message }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ERROR --}}
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i data-feather="alert-octagon" class="me-2"></i>
                        <strong>Lỗi:</strong> {{ $message }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- WARNINGS --}}
                @if (Session::has('warnings'))
                    <div class="alert alert-warning alert-dismissible fade show">
                        <i data-feather="alert-triangle" class="me-2"></i>
                        <strong>Phát hiện lỗi trong file CSV:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach (Session::get('warnings') as $warning)
                                <li>{{ $warning }}</li>
                            @endforeach
                        </ul>
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                {{-- UPLOAD FORM --}}
                <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf

                    {{-- FILE INPUT --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Chọn File CSV</label>
                        <input 
                            type="file"
                            id="csv_file"
                            name="csv_file"
                            accept=".csv,.txt"
                            required
                            class="form-control @error('csv_file') is-invalid @enderror"
                        >
                        <small class="text-muted">
                            Định dạng: .csv hoặc .txt · Dung lượng tối đa: 10MB
                        </small>

                        @error('csv_file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- FORMAT GUIDE --}}
                    <div class="alert alert-info">
                        <h5 class="fw-bold">
                            <i data-feather="info" class="me-2"></i>
                            Định dạng CSV bắt buộc
                        </h5>

                        <p class="mb-2">File phải chứa các cột theo thứ tự:</p>

                        <table class="table table-sm table-bordered bg-white">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th>Tên cột</th>
                                    <th style="width:100px;">Bắt buộc</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>student_code</td>
                                    <td><span class="text-dark badge bg-danger">Có</span></td>
                                    <td>Mã sinh viên (duy nhất)</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>full_name</td>
                                    <td><span class="text-dark badge bg-danger">Có</span></td>
                                    <td>Họ và Tên</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>gender</td>
                                    <td><span class="text-dark badge bg-secondary">Không</span></td>
                                    <td>Nam / Nữ </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>department</td>
                                    <td><span class="text-dark badge bg-secondary">Không</span></td>
                                    <td>Khoa – ngành học</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>class_name</td>
                                    <td><span class="text-dark badge bg-secondary">Không</span></td>
                                    <td>Lớp</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>email</td>
                                    <td><span class="text-dark badge bg-secondary">Không</span></td>
                                    <td>Email sinh viên</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    {{-- CSV EXAMPLE --}}
                    <div class="alert alert-secondary">
                        <h5 class="fw-bold">
                            <i data-feather="file-text" class="me-2"></i>
                            Ví dụ file CSV hợp lệ
                        </h5>

<pre class="bg-light p-3 rounded mb-0">
student_code,full_name,gender,department,class_name,email
DH52201580,Nguyễn Quốc Tịnh,Nam,Công nghệ thông tin,D22_TH02,dh52201580@student.stu.edu.vn  
DH52201581,Nguyễn Thị Kim Tỏa,Nữ,Công nghệ thông tin,D22_TH02,dh52201581@student.stu.edu.vn  
DH52201582,Phạm Văn K, Nam, Công nghệ thông tin,D22_TH02,dh52201582@student.stu.edu.vn  
DH52201583,Lê Thị O, Nữ, Công nghệ thông tin,D22_TH02,dh52201583@student.stu.edu.vn  
DH52201584,Hoàng Văn P, Nam, Công nghệ thông tin,D22_TH02,dh52201584@student.stu.edu.vn  
</pre>
                    </div>


                    {{-- BUTTONS --}}
                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-primary">
                            <i data-feather="upload" class="me-1"></i>
                            Import CSV
                        </button>

                        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                            <i data-feather="list" class="me-1"></i>
                            Xem danh sách sinh viên
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection
