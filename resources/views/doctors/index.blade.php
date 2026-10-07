@extends('layouts.app')
@section('title','Doctors')
@section('page-title','Doctors')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Doctors</span></div>
    <h1 class="page-title">Medical Staff</h1>
    <p class="page-subtitle">{{ $doctors->total() }} doctors registered</p>
  </div>
  <a href="{{ route('doctors.create') }}" class="btn btn-primary"><i class="fas fa-user-md"></i> Add Doctor</a>
</div>

<form method="GET" class="filter-bar">
  <div class="filter-search"><i class="fas fa-search"></i><input type="text" name="search" placeholder="Search by name, specialization..." value="{{ request('search') }}"></div>
  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i></button>
  @if(request('search'))<a href="{{ route('doctors.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i></a>@endif
</form>

@if($doctors->isEmpty())
<div class="card"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-user-md"></i></div><h3>No doctors yet</h3><a href="{{ route('doctors.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add First Doctor</a></div></div>
@else
<div class="grid grid-3">
  @foreach($doctors as $doctor)
  <div class="card" style="transition:all .2s;">
    <div style="height:6px;background:linear-gradient(90deg,var(--primary),var(--accent));"></div>
    <div class="card-body">
      <div class="flex items-center gap-3 mb-4">
        <div class="avatar avatar-lg" style="background:linear-gradient(135deg,{{ ['#0f6fff','#10b981','#f59e0b','#6366f1','#ef4444'][($doctor->id%5)] }},{{ ['#06b6d4','#34d399','#fbbf24','#818cf8','#f87171'][($doctor->id%5)] }});">
          {{ strtoupper(substr($doctor->user->name ?? 'D',0,2)) }}
        </div>
        <div>
          <div style="font-size:16px;font-weight:800;color:var(--gray-900);">Dr. {{ $doctor->user->name ?? '—' }}</div>
          <div style="font-size:13px;color:var(--primary);font-weight:600;">{{ $doctor->specialization }}</div>
          <div style="font-size:12px;color:var(--gray-400);">{{ $doctor->doctor_id }}</div>
        </div>
      </div>

      <div style="display:grid;gap:8px;margin-bottom:16px;">
        <div class="flex items-center gap-2"><i class="fas fa-graduation-cap" style="color:var(--primary);width:16px;font-size:12px;"></i><span style="font-size:13px;color:var(--gray-600);">{{ $doctor->qualification }}</span></div>
        <div class="flex items-center gap-2"><i class="fas fa-clock" style="color:var(--success);width:16px;font-size:12px;"></i><span style="font-size:13px;color:var(--gray-600);">{{ $doctor->experience_years }} years experience</span></div>
        <div class="flex items-center gap-2"><i class="fas fa-money-bill-wave" style="color:var(--warning);width:16px;font-size:12px;"></i><span style="font-size:13px;color:var(--gray-600);">₦{{ number_format($doctor->consultation_fee,0) }} / visit</span></div>
        <div class="flex items-center gap-2"><i class="fas fa-envelope" style="color:var(--info);width:16px;font-size:12px;"></i><span style="font-size:13px;color:var(--gray-600);truncate" class="truncate">{{ $doctor->user->email ?? '—' }}</span></div>
      </div>

      @if($doctor->available_days && count($doctor->available_days))
      <div style="margin-bottom:14px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);letter-spacing:.5px;margin-bottom:6px;">Available Days</div>
        <div class="flex gap-1 flex-wrap">
          @foreach($doctor->available_days as $day)
          <span style="background:var(--primary-soft);color:var(--primary);padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;">{{ substr($day,0,3) }}</span>
          @endforeach
        </div>
      </div>
      @endif

      <div class="flex items-center justify-between">
        <span class="badge badge-{{ $doctor->is_available ? 'success' : 'secondary' }}">{{ $doctor->is_available ? 'Available' : 'Unavailable' }}</span>
        <div class="flex gap-2">
          <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
          <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
<div style="margin-top:16px;">{{ $doctors->links() }}</div>
@endif
@endsection
