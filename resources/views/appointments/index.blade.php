@extends('layouts.app')
@section('title','Appointments')
@section('page-title','Appointments')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Appointments</span></div>
    <h1 class="page-title">Appointments</h1>
    <p class="page-subtitle">{{ $appointments->total() }} total appointments</p>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('appointments.calendar') }}" class="btn btn-outline"><i class="fas fa-calendar-alt"></i> Calendar View</a>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Book Appointment</a>
  </div>
</div>

<form method="GET" class="filter-bar">
  <div class="filter-search">
    <i class="fas fa-search"></i>
    <input type="text" name="search" placeholder="Search patient, appointment #..." value="{{ request('search') }}">
  </div>
  <input type="date" name="date" class="filter-select" value="{{ request('date') }}" onchange="this.form.submit()">
  <select name="status" class="filter-select" onchange="this.form.submit()">
    <option value="">All Status</option>
    @foreach(['pending','confirmed','completed','cancelled','no_show'] as $s)
    <option value="{{ $s }}" {{ request('status')==$s ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
    @endforeach
  </select>
  <select name="doctor_id" class="filter-select" onchange="this.form.submit()">
    <option value="">All Doctors</option>
    @foreach($doctors as $doc)
    <option value="{{ $doc->id }}" {{ request('doctor_id')==$doc->id ? 'selected':'' }}>Dr. {{ $doc->user->name }}</option>
    @endforeach
  </select>
  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
  @if(request()->hasAny(['search','status','date','doctor_id']))<a href="{{ route('appointments.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i></a>@endif
</form>

<div class="card">
  <div class="table-wrapper" style="border:none;border-radius:0;">
    <table class="table">
      <thead>
        <tr>
          <th>Appointment #</th>
          <th>Patient</th>
          <th>Doctor</th>
          <th>Date & Time</th>
          <th>Type</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($appointments as $apt)
        <tr>
          <td><code style="font-size:12px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $apt->appointment_number }}</code></td>
          <td>
            <div class="flex items-center gap-2">
              <div class="avatar avatar-sm">{{ strtoupper(substr($apt->patient->first_name,0,2)) }}</div>
              <div>
                <div style="font-weight:600;font-size:13px;">{{ $apt->patient->full_name }}</div>
                <div style="font-size:11px;color:var(--gray-400)">{{ $apt->patient->patient_id }}</div>
              </div>
            </div>
          </td>
          <td>
            <div style="font-size:13px;font-weight:500;">Dr. {{ $apt->doctor->user->name ?? '—' }}</div>
            <div style="font-size:11px;color:var(--gray-400);">{{ $apt->doctor->specialization ?? '' }}</div>
          </td>
          <td>
            <div style="font-weight:600;font-size:13px;">{{ $apt->appointment_date->format('M d, Y') }}</div>
            <div style="font-size:11px;color:var(--gray-400)">{{ date('h:i A', strtotime($apt->appointment_time)) }}</div>
          </td>
          <td style="font-size:12px;text-transform:capitalize;">{{ str_replace('_',' ',$apt->type) }}</td>
          <td>
            <span class="badge badge-{{ $apt->status_color }}">
              {{ ucfirst(str_replace('_',' ',$apt->status)) }}
            </span>
          </td>
          <td>
            <div class="table-actions">
              <a href="{{ route('appointments.show', $apt) }}" class="btn btn-outline btn-icon btn-sm" title="View"><i class="fas fa-eye"></i></a>
              <a href="{{ route('appointments.edit', $apt) }}" class="btn btn-outline btn-icon btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{ route('appointments.destroy', $apt) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-icon btn-sm" data-confirm="Cancel this appointment?"><i class="fas fa-times"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-calendar-times"></i></div><h3>No appointments found</h3><p>Adjust your filters or book a new appointment.</p><a href="{{ route('appointments.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Book Appointment</a></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $appointments->links() }}</div>
</div>
@endsection
