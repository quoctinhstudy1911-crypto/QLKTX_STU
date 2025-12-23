@extends('admin.layouts.master')
@section('title', 'Chi tiết hồ sơ')

@section('content')
<style>
    /* Làm chữ đậm & rõ hơn */
    .card h5 {
        font-weight: 600 !important;
        color: #000 !important;
    }

    .card p strong {
        color: #000 !important;
    }

    .card p {
        color: #222 !important;
        font-weight: 500;
    }

    /* Card rõ nét hơn */
    .card {
        border: 1px solid #e0e0e0 !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05) !important;
    }

    /* Label & form */
    label {
        font-weight: 600 !important;
        color: #000 !important;
    }

    .form-control, .form-select {
        border-color: #6c757d !important;
        color: #000 !important;
    }

    .form-control::placeholder {
        color: #555 !important;
    }

    /* Badge tương phản cao hơn */
    .badge {
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* List group sắc nét */
    .list-group-item {
        border-color: #d0d0d0 !important;
        color: #000 !important;
    }

    /* Nút chọn nổi bật */
    .btn-outline-primary {
        border-width: 2px !important;
        font-weight: 600 !important;
    }
</style>


<h1 class="h3 mb-3">Chi tiết hồ sơ</h1>

<div class="row">

    {{-- CỘT TRÁI : THÔNG TIN SINH VIÊN + FORM DUYỆT --}}
    <div class="col-md-6">

        {{-- THÔNG TIN --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5>Thông tin sinh viên</h5>

                <p><strong>Họ tên:</strong> {{ $req->full_name }}</p>
                <p><strong>Mã SV:</strong> {{ $req->student_code }}</p>
                <p><strong>Giới tính:</strong> {{ method_exists($req, 'gender_label') ? $req->gender_label : ($req->gender ?? '—') }}</p>
                <p><strong>SĐT:</strong> {{ $req->phone }}</p>
                <p><strong>Ưu tiên:</strong> {{ optional($req->priority)->name ?? '—' }}</p>
                <p><strong>Trạng thái:</strong> {{ ucfirst($req->status) }}</p>
                <p ><strong>Ghi chú:</strong> {{ $req->note }}</p>

                <p><strong>Loại sinh viên:</strong>
                    @if($isOld)
                        <span class="badge bg-info">Sinh viên cũ</span>
                    @else
                        <span class="badge bg-secondary">Sinh viên mới</span>
                    @endif
                </p>
            </div>
        </div>


        {{-- FORM DUYỆT --}}
        @if($req->status == 'pending')
        <div class="card">
            <div class="card-body">
                <h5>Duyệt hồ sơ & Xếp phòng</h5>

                <form method="POST" action="{{ route('admin.register.approve', $req->id) }}">
                    @csrf

                    {{-- CHỌN GIƯỜNG TRỰC TIẾP --}}
                    <div class="mb-3">
                        <label>Chọn giường trống</label>
                        <select name="bed_id" class="form-control">
                            <option value="">-- Không chọn --</option>

                            @foreach($availableBeds as $roomId => $beds)
                                <optgroup label="Phòng {{ \App\Models\Room::find($roomId)->room_number }}">
                                    @foreach($beds as $bed)
                                        <option value="{{ $bed->id }}">
                                            {{ $bed->bed_code }} — Phòng {{ $bed->room->room_number }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach

                        </select>
                    </div>

                    {{-- HOẶC CHỌN PHÒNG --}}
                    <div class="mb-3">
                        <label>Hoặc chọn phòng</label>
                        <select name="room_id" class="form-control">
                            <option value="">-- Chọn phòng --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">
                                    Phòng {{ $room->room_number }}
                                    ({{ $room->used_beds }}/{{ $room->total_beds }} giường)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success">Duyệt & Xếp phòng</button>
                </form>
            </div>
        </div>


        {{-- FORM TỪ CHỐI --}}
        <div class="card mt-3">
            <div class="card-body">
                <h5>Từ chối hồ sơ</h5>

                <form method="POST" action="{{ route('admin.register.reject', $req->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label>Lý do từ chối</label>
                        <textarea name="rejected_reason" class="form-control" rows="3" required"></textarea>
                    </div>
                    <button class="btn btn-danger">Từ chối</button>
                </form>
            </div>
        </div>
        @endif

    </div>



    {{-- CỘT PHẢI : GỢI Ý PHÒNG --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Phòng phù hợp (theo giới tính & giường trống)</h5>

                @if($rooms->isEmpty())
                    <p class="text-muted">Không có phòng nào phù hợp.</p>

                @else
                    <ul class="list-group">
                        @foreach($rooms as $room)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Phòng {{ $room->room_number }}</strong>
                                    <div class="small text-muted">
                                        Giường: {{ $room->used_beds }} / {{ $room->total_beds }}
                                    </div>
                                </div>

                                <form action="{{ route('admin.register.approve', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        Chọn
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>

                @endif

            </div>
        </div>
    </div>

</div>

@endsection
