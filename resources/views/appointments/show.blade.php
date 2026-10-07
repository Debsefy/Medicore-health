@extends('layouts.app')
@section('title', 'Appointment Details')
@section('page-title', 'Appointment Details')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('appointments.index') }}">Appointments</a><span>/</span><span>{{ $appointment->appointment_number }}</span></div>
    <h1 class="page-title">{{ $appointment->appointment_number }}</h1>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Edit</a>
    @if(!$appointment->medicalRecord)
      <a href="{{ route('medical-records.create') }}?appointment_id={{ $appointment->id }}&patient_id={{ $appointment->patient_id }}" class="btn btn-primary"><i class="fas fa-file-medical"></i> Add Medical Record</a>
    @endif
  </div>
</div>

<div class="grid grid-12">
  <div class="col-8">
    <div class="card mb-4">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar-check" style="color:var(--primary);margin-right:8px;"></i>Appointment Info</h3>
        <span class="badge badge-{{ $appointment->status_color }} badge-lg">{{ ucfirst(str_replace('_',' ',$appointment->status)) }}</span>
      </div>
      <div class="card-body">
        <div class="grid grid-2 gap-4 mb-4">
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);letter-spacing:.5px;">Date</label><p style="font-size:15px;font-weight:600;margin-top:4px;">{{ $appointment->appointment_date->format('l, M d, Y') }}</p></div>
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);letter-spacing:.5px;">Time</label><p style="font-size:15px;font-weight:600;margin-top:4px;">{{ date('h:i A', strtotime($appointment->appointment_time)) }}</p></div>
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);letter-spacing:.5px;">Type</label><p style="font-size:15px;font-weight:600;margin-top:4px;text-transform:capitalize;">{{ str_replace('_',' ',$appointment->type) }}</p></div>
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);letter-spacing:.5px;">Booked By</label><p style="font-size:15px;font-weight:600;margin-top:4px;">{{ $appointment->booked_by ?? 'System' }}</p></div>
        </div>
        @if($appointment->reason)
        <div style="background:var(--gray-50);border-radius:8px;padding:14px;margin-bottom:12px;">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);letter-spacing:.5px;margin-bottom:6px;">Reason for Visit</div>
          <p style="font-size:14px;color:var(--gray-700);">{{ $appointment->reason }}</p>
        </div>
        @endif
        @if($appointment->notes)
        <div style="background:var(--gray-50);border-radius:8px;padding:14px;">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);letter-spacing:.5px;margin-bottom:6px;">Notes</div>
          <p style="font-size:14px;color:var(--gray-700);">{{ $appointment->notes }}</p>
        </div>
        @endif
      </div>
    </div>

    @if($appointment->medicalRecord)
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-medical" style="color:var(--success);margin-right:8px;"></i>Medical Record</h3>
        <a href="{{ route('medical-records.show', $appointment->medicalRecord) }}" class="btn btn-outline btn-sm">View Full Record</a>
      </div>
      <div class="card-body">
        <div class="grid grid-2 gap-4 mb-3">
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);">Chief Complaint</label><p style="font-size:14px;margin-top:4px;">{{ $appointment->medicalRecord->chief_complaint }}</p></div>
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);">Diagnosis</label><p style="font-size:14px;margin-top:4px;">{{ $appointment->medicalRecord->diagnosis }}</p></div>
        </div>
        @if($appointment->medicalRecord->weight || $appointment->medicalRecord->blood_pressure)
        <div class="vitals-grid">
          @if($appointment->medicalRecord->weight)<div class="vital-item"><div class="vital-icon"><i class="fas fa-weight"></i></div><div class="vital-value">{{ $appointment->medicalRecord->weight }} kg</div><div class="vital-label">Weight</div></div>@endif
          @if($appointment->medicalRecord->height)<div class="vital-item"><div class="vital-icon"><i class="fas fa-ruler-vertical"></i></div><div class="vital-value">{{ $appointment->medicalRecord->height }} cm</div><div class="vital-label">Height</div></div>@endif
          @if($appointment->medicalRecord->blood_pressure)<div class="vital-item"><div class="vital-icon"><i class="fas fa-heartbeat"></i></div><div class="vital-value">{{ $appointment->medicalRecord->blood_pressure }}</div><div class="vital-label">Blood Pressure</div></div>@endif
          @if($appointment->medicalRecord->temperature)<div class="vital-item"><div class="vital-icon"><i class="fas fa-thermometer-half"></i></div><div class="vital-value">{{ $appointment->medicalRecord->temperature }}°C</div><div class="vital-label">Temperature</div></div>@endif
          @if($appointment->medicalRecord->pulse_rate)<div class="vital-item"><div class="vital-icon"><i class="fas fa-heart"></i></div><div class="vital-value">{{ $appointment->medicalRecord->pulse_rate }} bpm</div><div class="vital-label">Pulse</div></div>@endif
        </div>
        @endif
      </div>
    </div>
    @endif
  </div>

  <div class="col-4" style="display:flex;flex-direction:column;gap:16px;">
    <!-- Patient Card -->
    <div class="card">
      <div class="card-header"><h3 class="card-title">Patient</h3></div>
      <div class="card-body">
        <div class="flex items-center gap-3 mb-3">
          <div class="avatar">{{ strtoupper(substr($appointment->patient->first_name,0,2)) }}</div>
          <div><div style="font-weight:700;">{{ $appointment->patient->full_name }}</div><div style="font-size:12px;color:var(--gray-400);">{{ $appointment->patient->patient_id }}</div></div>
        </div>
        <div style="font-size:13px;color:var(--gray-600);display:flex;flex-direction:column;gap:6px;">
          <span><i class="fas fa-phone" style="color:var(--primary);width:16px;"></i> {{ $appointment->patient->phone }}</span>
          <span><i class="fas fa-tint" style="color:var(--danger);width:16px;"></i> {{ $appointment->patient->blood_type ?? 'Unknown' }}</span>
          <span><i class="fas fa-birthday-cake" style="color:var(--warning);width:16px;"></i> Age {{ $appointment->patient->age }}</span>
        </div>
        <div class="mt-3">
          <a href="{{ route('patients.show', $appointment->patient) }}" class="btn btn-outline btn-sm w-full" style="justify-content:center;">View Patient Profile</a>
        </div>
      </div>
    </div>

    <!-- Doctor Card -->
    <div class="card">
      <div class="card-header"><h3 class="card-title">Doctor</h3></div>
      <div class="card-body">
        <div class="flex items-center gap-3 mb-3">
          <div class="avatar" style="background:linear-gradient(135deg,var(--success),#34d399);">{{ strtoupper(substr($appointment->doctor->user->name ?? 'D',0,2)) }}</div>
          <div><div style="font-weight:700;">Dr. {{ $appointment->doctor->user->name ?? '—' }}</div><div style="font-size:12px;color:var(--gray-400);">{{ $appointment->doctor->specialization }}</div></div>
        </div>
        <div style="font-size:13px;color:var(--gray-600);">
          <span><i class="fas fa-graduation-cap" style="color:var(--primary);width:16px;"></i> {{ $appointment->doctor->qualification }}</span>
        </div>
      </div>
    </div>

    <!-- Update Status -->
    <div class="card">
      <div class="card-header"><h3 class="card-title">Update Status</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('appointments.update', $appointment) }}">
          @csrf @method('PUT')
          <input type="hidden" name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d') }}">
          <input type="hidden" name="appointment_time" value="{{ $appointment->appointment_time }}">
          <input type="hidden" name="type" value="{{ $appointment->type }}">
          <div class="form-group">
            <select name="status" class="form-select">
              @foreach(['pending','confirmed','completed','cancelled','no_show'] as $s)
              <option value="{{ $s }}" {{ $appointment->status==$s ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-full" style="justify-content:center;"><i class="fas fa-save"></i> Update Status</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
