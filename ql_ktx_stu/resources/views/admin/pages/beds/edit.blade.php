@extends('admin.layouts.master')
@section('title', 'Cập nhật giường')

@section('content')

<h1 class="h3 mb-3"><strong>Cập nhật giường</strong></h1>

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

        <form method="POST" action="{{ route('admin.beds.update', $bed) }}">
            @csrf 
            @method('PUT')

            {{-- CHỌN PHÒNG --}}
            <div class="mb-3">
                <label class="form-label">Chọn phòng</label>
                <select name="room_id" class="form-control">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}"
                            {{ old('room_id', $bed->room_id) == $room->id ? 'selected' : '' }}>
                            Phòng {{ $room->room_number }} ({{ $room->gender_label }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- MÃ GIƯỜNG --}}
            <div class="mb-3">
                <label class="form-label">Mã giường</label>
                  <input type="text" 
                      name="bed_code" 
                      class="form-control @error('bed_code') is-invalid @enderror"
                      value="{{ old('bed_code', $bed->bed_code) }}"
                      pattern="[ABC][1-9]"
                      placeholder="VD: A1, B5, C9"
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
                    <option value="available" 
                        {{ old('status', $bed->status) == 'available' ? 'selected' : '' }}>
                        Trống
                    </option>

                    <option value="occupied" 
                        {{ old('status', $bed->status) == 'occupied' ? 'selected' : '' }}>
                        Đã dùng
                    </option>

                    <option value="maintenance" 
                        {{ old('status', $bed->status) == 'maintenance' ? 'selected' : '' }}>
                        Bảo trì
                    </option>
                </select>
            </div>

            {{-- GHI CHÚ --}}
            <div class="mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea name="note" class="form-control" rows="2">{{ old('note', $bed->note) }}</textarea>
            </div>

            <button class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.beds.index') }}" class="btn btn-secondary">Quay lại</a>

        </form>

    </div>
</div>

@endsection
