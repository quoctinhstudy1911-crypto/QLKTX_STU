@extends('admin.layouts.master')
@section('title', 'Lịch sử hoạt động')

@section('content')
<h1 class="h3 mb-3"><strong>Lịch sử hoạt động hệ thống</strong></h1>

<div class="card shadow-sm">
    <div class="card-body">

        {{-- ============== TABLE ============== --}}
        <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 220px">Người thực hiện</th>
                        <th style="width: 120px">Hành động</th>
                        <th>Mô tả</th>
                        <th style="width: 120px">IP</th>
                        <th style="width: 140px">Thời gian</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($logs as $log)
                        <tr>
                        <td>
                        @if ($log->user) 
                            {{-- Nếu là user có profile --}}
                            {{ $log->user->profile->full_name ?? $log->user->email }}

                        @else
                            {{-- Nếu không có user → chắc chắn là Admin --}}
                            (Admin)

                        @endif
                    </td>
                            <td>
                               <span class="badge text-dark 
                                    @if($log->action === 'created') bg-success
                                    @elseif($log->action === 'updated') bg-warning
                                    @elseif($log->action === 'deleted') bg-danger
                                    @else bg-primary
                                    @endif
                                ">
                                    {{ $log->action }}
                                </span>
                            </td>

                            <td>{{ $log->description }}</td>

                            <td>{{ $log->ip_address }}</td>

                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                Chưa có hoạt động nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- ============== PAGINATION ============== --}}
        <div class="card-footer bg-white border-0">
            <div class="pagination-center">
                {{ $logs->links('vendor.pagination.custom') }}
            </div>
        </div>

    </div>
</div>
@endsection

