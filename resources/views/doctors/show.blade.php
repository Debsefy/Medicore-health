@extends('layouts.app')
@section('title','Doctor Profile')
@section('page-title','Doctor Profile')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('doctors.index') }}">Doctors</a><span>/</span><span>{{ $doctor->user->name ?? '' }}</span></div>
    <h1 class="page-title">Dr. {{ $doctor->user->name ?? '—' }}</h1>
    <p class="page-subtitle">{{ $doctor->doctor_id }} &middot; {{ $doctor->specialization }}</p>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('doctors.edit',$doctor) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Edit</a>
    <a href="{{ route('appointments.create') }}?doctor_id={{ $doctor->id }}" class="btn btn-primary"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
  </div>
</div>

<div class="grid grid-12">
  <div class="col-4" style="display:flex;flex-direction:column;gap:18px;">
    <div class="card">
      <div class="profile-card-banner" style="background:linear-gradient(135deg,var(--success),#34d399);"></div>
      <div class="profile-card-body">
        <div class="profile-card-avatar">
          <div class="avatar" style="width:64px;height:64px;font-size:22px;border:3px solid var(--white);box-shadow:var(--shadow-sm);background:linear-gradient(135deg,var(--success),#34d399);">{{ strtoupper(substr($doctor->user->name??'D',0,2)) }}</div>
        </div>
        <h2 style="font-size:20px;font-weight:800;">Dr. {{ $doctor->user->name ?? '—' }}</h2>
        <p style="color:var(--success);font-weight:600;font-size:14px;">{{ $doctor->specialization }}</p>
        <div class="flex gap-2 mt-2 flex-wrap">
          <span class="badge badge-{{ $doctor->is_available?'success':'secondary' }}">{{ $doctor->is_available?'Available':'Unavailable' }}</span>
          <span class="badge badge-primary">{{ $doctor->doctor_id }}</span>
        </div>
        <div style="margin-top:16px;display:grid;gap:10px;">
          <div class="flex items-center gap-2"><i class="fas fa-graduation-cap" style="color:var(--primary);width:16px;font-size:12px;"></i><span style="font-size:13px;">{{ $doctor->qualification }}</span></div>
          <div class="flex items-center gap-2"><i class="fas fa-clock" style="color:var(--success);width:16px;font-size:12px;"></i><span style="font-size:13px;">{{ $doctor->experience_years }} years experience</span></div>
          <div class="flex items-center gap-2"><i class="fas fa-money-bill-wave" style="color:var(--warning);width:16px;font-size:12px;"></i><span style="font-size:13px;">₦{{ number_format($doctor->consultation_fee,0) }} consultation</span></div>
          <div class="flex items-center gap-2"><i class="fas fa-envelope" style="color:var(--info);width:16px;font-size:12px;"></i><span style="font-size:13px;">{{ $doctor->user->email??'—' }}</span></div>
          <div class="flex items-center gap-2"><i class="fas fa-phone" style="color:var(--danger);width:16px;font-size:12px;"></i><span style="font-size:13px;">{{ $doctor->user->phone??'—' }}</span></div>
          @if($doctor->license_number)<div class="flex items-center gap-2"><i class="fas fa-id-card" style="color:var(--gray-400);width:16px;font-size:12px;"></i><span style="font-size:13px;">{{ $doctor->license_number }}</span></div>@endif
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3 class="card-title">Quick Stats</h3></div>
      <div class="card-body"><div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;text-align:center;">
        <div><div style="font-size:26px;font-weight:800;color:var(--primary);">{{ $stats['total_appointments'] }}</div><div style="font-size:12px;color:var(--gray-500);">Total Appts</div></div>
        <div><div style="font-size:26px;font-weight:800;color:var(--success);">{{ $stats['completed'] }}</div><div style="font-size:12px;color:var(--gray-500);">Completed</div></div>
        <div><div style="font-size:26px;font-weight:800;color:var(--warning);">{{ $stats['today'] }}</div><div style="font-size:12px;color:var(--gray-500);">Today</div></div>
      </div></div>
    </div>
    @if($doctor->available_days && count($doctor->available_days))
    <div class="card">
      <div class="card-header"><h3 class="card-title">Schedule</h3></div>
      <div class="card-body">
        <div class="flex gap-2 flex-wrap mb-3">@foreach($doctor->available_days as $d)<span style="background:var(--success-soft);color:var(--success);padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">{{ $d }}</span>@endforeach</div>
        @if($doctor->available_from)<p style="font-size:13px;color:var(--gray-600);"><i class="fas fa-clock" style="color:var(--primary);"></i> {{ date('h:i A',strtotime($doctor->available_from)) }} – {{ date('h:i A',strtotime($doctor->available_to)) }}</p>@endif
      </div>
    </div>
    @endif
  </div>

  <div class="col-8">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Recent Appointments</h3></div>
      <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
          <thead><tr><th>Patient</th><th>Date</th><th>Type</th><th>Status</th></tr></thead>
          <tbody>
            @forelse($appointments as $apt)
            <tr>
              <td><div style="font-weight:600;font-size:13px;">{{ $apt->patient->full_name }}</div><div style="font-size:11px;color:var(--gray-400);">{{ $apt->patient->patient_id }}</div></td>
              <td><div style="font-size:13px;font-weight:500;">{{ $apt->appointment_date->format('M d, Y') }}</div><div style="font-size:11px;color:var(--gray-400);">{{ date('h:i A',strtotime($apt->appointment_time)) }}</div></td>
              <td style="font-size:12px;text-transform:capitalize;">{{ str_replace('_',' ',$apt->type) }}</td>
              <td><span class="badge badge-{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:24px;color:var(--gray-400);">No appointments yet</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if($doctor->bio)
    <div class="card mt-4">
      <div class="card-header"><h3 class="card-title">Biography</h3></div>
      <div class="card-body"><p style="font-size:14px;color:var(--gray-700);line-height:1.8;">{{ $doctor->bio }}</p></div>
    </div>
    @endif
  </div>
</div>
@endsection
