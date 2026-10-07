@extends('layouts.app')
@section('title','Audit Logs')
@section('page-title','Audit Logs')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Audit Logs</span></div>
    <h1 class="page-title">System Audit Logs</h1>
    <p class="page-subtitle">Track all system activities</p>
  </div>
</div>

<div class="card">
  <div class="table-wrapper" style="border:none;border-radius:0;">
    <table class="table">
      <thead><tr><th>User</th><th>Action</th><th>Record</th><th>IP Address</th><th>Time</th></tr></thead>
      <tbody>
        @forelse($logs as $log)
        <tr>
          <td>
            <div class="flex items-center gap-2">
              <div class="avatar avatar-sm">{{ strtoupper(substr($log->user->name ?? 'S',0,2)) }}</div>
              <div>
                <div style="font-weight:600;font-size:13px;">{{ $log->user->name ?? 'System' }}</div>
                <div style="font-size:11px;color:var(--gray-400);">{{ $log->user->role ?? '' }}</div>
              </div>
            </div>
          </td>
          <td>
            @php
              $actionColor = str_contains(strtolower($log->action),'delet') ? 'danger' : (str_contains(strtolower($log->action),'creat') ? 'success' : (str_contains(strtolower($log->action),'login') ? 'primary' : 'warning'));
            @endphp
            <span class="badge badge-{{ $actionColor }}">{{ $log->action }}</span>
          </td>
          <td style="font-size:13px;">
            @if($log->model_type)
              <span style="color:var(--gray-500);">{{ class_basename($log->model_type) }}</span>
              @if($log->model_id) <span style="color:var(--gray-400);">#{{ $log->model_id }}</span>@endif
            @else —@endif
          </td>
          <td style="font-size:13px;font-family:monospace;">{{ $log->ip_address ?? '—' }}</td>
          <td>
            <div style="font-size:13px;">{{ $log->created_at->format('M d, Y') }}</div>
            <div style="font-size:11px;color:var(--gray-400);">{{ $log->created_at->format('h:i A') }}</div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-history"></i></div><h3>No audit logs yet</h3></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $logs->links() }}</div>
</div>
@endsection
