@extends('layouts.app')
@section('title','Users')
@section('page-title','User Management')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Users</span></div>
    <h1 class="page-title">System Users</h1>
    <p class="page-subtitle">{{ $users->total() }} registered users</p>
  </div>
  <a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add User</a>
</div>

<div class="card">
  <div class="table-wrapper" style="border:none;border-radius:0;">
    <table class="table">
      <thead><tr><th>User</th><th>Role</th><th>Phone</th><th>Status</th><th>Last Login</th><th>Joined</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td>
            <div class="flex items-center gap-3">
              <div class="avatar avatar-sm" style="background:linear-gradient(135deg,{{ ['admin'=>'#ef4444,#f87171','doctor'=>'#0f6fff,#06b6d4','nurse'=>'#10b981,#34d399','receptionist'=>'#f59e0b,#fbbf24'][$user->role] ?? '#64748b,#94a3b8' }});">{{ strtoupper(substr($user->name,0,2)) }}</div>
              <div>
                <div style="font-weight:600;font-size:13.5px;">{{ $user->name }}</div>
                <div style="font-size:11px;color:var(--gray-400);">{{ $user->email }}</div>
              </div>
            </div>
          </td>
          <td>{!! $user->role_badge !!}</td>
          <td style="font-size:13px;">{{ $user->phone ?? '—' }}</td>
          <td>
            <span class="badge badge-{{ $user->is_active ? 'success':'secondary' }}">{{ $user->is_active ? 'Active':'Inactive' }}</span>
          </td>
          <td style="font-size:13px;">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>
          <td style="font-size:13px;">{{ $user->created_at->format('M d, Y') }}</td>
          <td>
            <div class="table-actions">
              <button class="btn btn-outline btn-icon btn-sm" title="Edit"><i class="fas fa-edit"></i></button>
              @if($user->id !== auth()->id())
              <button class="btn btn-danger btn-icon btn-sm" data-confirm="Deactivate {{ $user->name }}?" title="Deactivate"><i class="fas fa-ban"></i></button>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-users"></i></div><h3>No users found</h3></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $users->links() }}</div>
</div>
@endsection
