@extends('admin.layouts.app')
@section('title', 'Cập nhật phòng')

@section('content')

<h1 class="h3 mb-3">Cập nhật phòng</h1>

<div class="card">
    <div class="card-body">
        
        <form method="POST" action="{{ route('admin.rooms.update', $room) }}">
            @csrf @method('PUT')

            <div class="row">

                {{-- SỐ PHÒNG --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Số phòng <span class="text-danger">*</span></label>
                          <input type="text" name="room_number" 
                              value="{{ old('room_number', $room->room_number) }}" 
                              class="form-control @error('room_number') is-invalid @enderror" 
                              placeholder="P1, P2, ..., P10" required>
                          <small class="form-text text-muted d-block mt-1">Định dạng: P1 đến P10 (ví dụ: P1, P5, P10)</small>
                    @error('room_number')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TẦNG (BẮT BUỘC) --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tầng <span class="text-danger">*</span></label>
                    <select name="floor" class="form-control @error('floor') is-invalid @enderror" required>
                        <option value="">-- Chọn tầng --</option>
                        <option value="1" {{ old('floor', $room->floor) == 1 ? 'selected' : '' }}>Tầng 1</option>
                        <option value="2" {{ old('floor', $room->floor) == 2 ? 'selected' : '' }}>Tầng 2</option>
                    </select>
                    @error('floor')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            {{-- GIỚI TÍNH --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                    <option value="">-- Chọn giới tính --</option>
                    <option value="{{ \App\Models\Room::genderMale() }}" {{ old('gender', $room->gender) == \App\Models\Room::genderMale() ? 'selected' : '' }}>Nam</option>
                    <option value="{{ \App\Models\Room::genderFemale() }}" {{ old('gender', $room->gender) == \App\Models\Room::genderFemale() ? 'selected' : '' }}>Nữ</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

                {{-- SỨC CHỨA --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sức chứa <span class="text-danger">*</span></label>
                    <input type="number" name="capacity" 
                           value="{{ old('capacity', $room->capacity) }}" 
                           class="form-control @error('capacity') is-invalid @enderror" min="1" max="27" required>
                    <small class="form-text text-muted d-block mt-1">Tối đa 27 giường (3 dãy A, B, C × 3 cụm × 3 giường)</small>
                    @error('capacity')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DIỆN TÍCH --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Diện tích (m²)</label>
                    <input type="number" name="area" 
                           value="{{ old('area', $room->area) }}" 
                           class="form-control @error('area') is-invalid @enderror" step="0.1">
                    @error('area')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- LOẠI PHÒNG --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Loại phòng <span class="text-danger">*</span></label>
                    <select name="room_type" class="form-control @error('room_type') is-invalid @enderror" required>
                        <option value="">-- Chọn loại phòng --</option>
                        <option value="Thường" {{ old('room_type', $room->room_type) == 'Thường' ? 'selected' : '' }}>Phòng Thường</option>
                        <option value="VIP" {{ old('room_type', $room->room_type) == 'VIP' ? 'selected' : '' }}>Phòng VIP</option>
                        <option value="Đặc biệt" {{ old('room_type', $room->room_type) == 'Đặc biệt' ? 'selected' : '' }}>Phòng Đặc biệt</option>
                    </select>
                    @error('room_type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- MÔ TẢ --}}
                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" 
                              class="form-control @error('description') is-invalid @enderror" 
                              rows="3">{{ old('description', $room->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <button class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Hủy</a>

        </form>

    </div>
</div>

@endsection
