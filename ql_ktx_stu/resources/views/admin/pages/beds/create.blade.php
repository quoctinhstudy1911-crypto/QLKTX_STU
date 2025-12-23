@extends('admin.layouts.master')
@section('title', 'Thêm giường')

@section('content')

<h1 class="h3 mb-3">Thêm giường</h1>

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.beds.store') }}">
            @csrf

            <div class="mb-3">
                <label>Chọn phòng</label>
                <select name="room_id" class="form-control">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->room_number }} ({{ $room->gender_label }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Mã giường</label>
                <input type="text" name="bed_code" class="form-control" placeholder="VD: A101-1">
            </div>

            <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="available">Đang trống</option>
                    <option value="occupied">Đã dùng</option>
                    <option value="maintenance">Bảo trì</option>
                </select>
            </div>
@extends('admin.layouts.master')
@section('title', 'Thêm giường')

@section('content')

<h1 class="h3 mb-3"><strong>Thêm giường mới</strong></h1>

<div class="card">
    <div class="card-body">

        {{-- HIỂN THỊ LỖI --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.beds.store') }}">
            @csrf

            {{-- CHỌN PHÒNG --}}
            <div class="mb-3">
                <label class="form-label">Chọn phòng</label>
                <select name="room_id" class="form-control">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" 
                            {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            Phòng {{ $room->room_number }} — {{ $room->gender_label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- MÃ GIƯỜNG --}}
            <div class="mb-3">
                <label class="form-label">Mã giường</label>
                  <input type="text" 
                      name="bed_code" 
                      value="{{ old('bed_code') }}"
                      class="form-control @error('bed_code') is-invalid @enderror"
                      placeholder="VD: A1, B5, C9"
                      pattern="[ABC][1-9]"
                      title="Mã giường phải có dạng A1–A9, B1–B9, C1–C9">
                  <small class="text-muted d-block">Dạng: Dãy (A/B/C) + Số (1-9). Ví dụ: A1, B5, C9</small>
                  @error('bed_code')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
            </div>

            {{-- TRẠNG THÁI --}}
            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="available"   {{ old('status') == 'available' ? 'selected' : '' }}>Đang trống</option>
                    <option value="occupied"    {{ old('status') == 'occupied' ? 'selected' : '' }}>Đã dùng</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                </select>
            </div>

            {{-- GHI CHÚ --}}
            <div class="mb-3">
                <label class="form-label">Ghi chú (không bắt buộc)</label>
                <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
            </div>

            <button class="btn btn-primary">Lưu giường</button>
            <a href="{{ route('admin.beds.index') }}" class="btn btn-secondary">Quay lại</a>

        </form>

    </div>
</div>

@endsection

            <button class="btn btn-primary">Lưu</button>
        </form>

    </div>
</div>

@endsection
