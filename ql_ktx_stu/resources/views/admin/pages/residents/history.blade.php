@extends('admin.layouts.master')
@section('title','Lịch sử lưu trú')

@section('content')
<h1 class="h3 mb-3"><strong>Lịch sử lưu trú</strong></h1>

<div class="card shadow-sm">
  <div class="card-body">

    <table class="table table-striped">
      <thead>
        <tr>
            <th>Phòng</th>
            <th>Giường</th>
            <th>Học kỳ</th>
            <th>Check-in</th>
            <th>Check-out</th>
        </tr>
      </thead>

      <tbody>
        @foreach($history as $row)
        <tr>
            <td>{{ $row->room->room_number ?? '—' }}</td>
            <td>{{ $row->bed->bed_code ?? '—' }}</td>
            <td>
                {{ optional($row->hocKy)->school_year }}
                (HK{{ optional($row->hocKy)->semester }})
            </td>
            <td>{{ $row->check_in_date }}</td>
            <td>{{ $row->check_out_date ?? '—' }}</td>
        </tr>
        @endforeach
      </tbody>

    </table>

    <div class="mt-3"> {{ $history->links('vendor.pagination.custom') }} </div>
  </div>
</div>

@endsection
