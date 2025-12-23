@extends('admin.layouts.app')
@section('title', 'Thêm phòng')

@section('content')

<h1 class="h3 mb-3">Thêm phòng mới</h1>

<div class="card">
    <div class="card-body">
        
        <form method="POST" action="{{ route('admin.rooms.store') }}">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Số phòng <span class="text-danger">*</span></label>
                          <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" 
                              value="{{ old('room_number') }}" placeholder="P1, P2, ..., P10" required>
                          <small class="form-text text-muted d-block mt-1">Định dạng: P1 đến P10 (ví dụ: P1, P5, P10)</small>
                    @error('room_number')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

               <div class="col-md-6 mb-3">
                    <label class="form-label">Tầng <span class="text-danger">*</span></label>
                    <select name="floor" class="form-control @error('floor') is-invalid @enderror" required>
                        <option value="">-- Chọn tầng --</option>
                        <option value="1" {{ old('floor') == '1' ? 'selected' : '' }}>Tầng 1</option>
                        <option value="2" {{ old('floor') == '2' ? 'selected' : '' }}>Tầng 2</option>
                    </select>
                    @error('floor')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
               </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                        <option value="">-- Chọn giới tính --</option>
                        <option value="{{ \App\Models\Room::genderMale() }}" {{ old('gender') == \App\Models\Room::genderMale() ? 'selected' : '' }}>Nam</option>
                        <option value="{{ \App\Models\Room::genderFemale() }}" {{ old('gender') == \App\Models\Room::genderFemale() ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Sức chứa <span class="text-danger">*</span></label>
                    <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" 
                           value="{{ old('capacity') }}" required min="1" max="27">
                    <small class="form-text text-muted d-block mt-1">Tối đa 27 giường (3 dãy A, B, C × 3 cụm × 3 giường)</small>
                    @error('capacity')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Diện tích phòng (m²)</label>
                    <input type="number" name="area" class="form-control @error('area') is-invalid @enderror" 
                           value="{{ old('area') }}" placeholder="Ví dụ: 20" step="0.1">
                    @error('area')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Loại phòng <span class="text-danger">*</span></label>
                    <select name="room_type" class="form-control @error('room_type') is-invalid @enderror" required>
                        <option value="">-- Chọn loại phòng --</option>
                        <option value="Thường" {{ old('room_type') == 'Thường' ? 'selected' : '' }}>Phòng Thường</option>
                        <option value="VIP" {{ old('room_type') == 'VIP' ? 'selected' : '' }}>Phòng VIP</option>
                        <option value="Đặc biệt" {{ old('room_type') == 'Đặc biệt' ? 'selected' : '' }}>Phòng Đặc biệt</option>
                    </select>
                    @error('room_type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="3" placeholder="Mô tả phòng, tiện ích...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <button class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Hủy</a>
        </form>

    </div>
</div>

@endsection
