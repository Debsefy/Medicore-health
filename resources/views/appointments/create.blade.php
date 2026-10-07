@extends('layouts.app')
@section('title','Book Appointment')
@section('page-title','Book Appointment')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('appointments.index') }}">Appointments</a><span>/</span><span>Book New</span></div>
    <h1 class="page-title">Book New Appointment</h1>
  </div>
  <a href="{{ route('appointments.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:760px;">
<form method="POST" action="{{ route('appointments.store') }}">
@csrf
<div class="card">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-calendar-plus" style="color:var(--primary);margin-right:8px;"></i>Appointment Details</h3></div>
  <div class="card-body">

    <div class="form-row cols-2">
      <div class="form-group">
        <label class="form-label">Patient <span>*</span></label>
        <select name="patient_id" class="form-select" required>
          <option value="">— Select patient —</option>
          @foreach($patients as $p)
          <option value="{{ $p->id }}" {{ (request('patient_id')==$p->id || old('patient_id')==$p->id) ? 'selected':'' }}>
            {{ $p->full_name }} ({{ $p->patient_id }})
          </option>
          @endforeach
        </select>
        @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Doctor <span>*</span></label>
        <select name="doctor_id" class="form-select" required>
          <option value="">— Select doctor —</option>
          @foreach($doctors as $doc)
          <option value="{{ $doc->id }}" {{ old('doctor_id')==$doc->id ? 'selected':'' }}>
            Dr. {{ $doc->user->name }} — {{ $doc->specialization }}
          </option>
          @endforeach
        </select>
        @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="form-row cols-3">
      <div class="form-group">
        <label class="form-label">Date <span>*</span></label>
        <input type="date" name="appointment_date" class="form-control today-default" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required>
        @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Time <span>*</span></label>
        <input type="time" name="appointment_time" class="form-control" value="{{ old('appointment_time','09:00') }}" required>
        @error('appointment_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Type <span>*</span></label>
        <select name="type" class="form-select" required>
          <option value="consultation"  {{ old('type')=='consultation'  ? 'selected':'' }}>Consultation</option>
          <option value="follow_up"     {{ old('type')=='follow_up'     ? 'selected':'' }}>Follow-up</option>
          <option value="emergency"     {{ old('type')=='emergency'     ? 'selected':'' }}>Emergency</option>
          <option value="routine"       {{ old('type')=='routine'       ? 'selected':'' }}>Routine Check</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Reason for Visit</label>
      <textarea name="reason" class="form-control" rows="3" placeholder="Brief description of why the patient is visiting...">{{ old('reason') }}</textarea>
    </div>

    <div class="form-group">
      <label class="form-label">Additional Notes</label>
      <textarea name="notes" class="form-control" rows="2" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
    </div>

    <div class="flex gap-3 justify-end mt-4">
      <a href="{{ route('appointments.index') }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-calendar-check"></i> Book Appointment</button>
    </div>
  </div>
</div>
</form>
</div>
@endsection
