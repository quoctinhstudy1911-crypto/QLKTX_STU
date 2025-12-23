@extends('guest.layouts.master')

@section('title', 'Trang chủ')

@section('content')

<div class="card shadow-sm p-4">

    <h3 class="fw-bold mb-3">Chào mừng đến hệ thống Ký túc xá STU</h3>

    <p class="text-muted">
        Bạn có thể đăng ký nội trú, tra cứu trạng thái xét duyệt và xem hướng dẫn ngay tại đây.
    </p>

    <div class="text-center mt-4">
        <img src="{{ asset('assets/img/Hinh_STU.png') }}" width="max(300px, 100%)" alt="Hình STU">
    </div>
</div>

@endsection
