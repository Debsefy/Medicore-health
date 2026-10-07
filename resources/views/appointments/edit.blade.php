@extends('layouts.app')
@section('title','Edit Appointment')
@section('page-title','Edit Appointment')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('appointments.index') }}">Appointments</a><span>/</span><span>Edit</span></div>
    <h1 class="page-title">Edit Appointment</h1>
  </div>
  <a href="{{ route('appointments.show',$appointment) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div style="max-width:700px;">
<form method="POST" action="{{ route('appointments.update',$appointment) }}">
@csrf @method('PUT')
<div class="card">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-calendar-edit" style="color:var(--primary);margin-right:8px;"></i>Appointment Details</h3></div>
  <div class="card-body">
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Patient</label><input type="text" class="form-control" value="{{ $appointment->patient->full_name }}" disabled></div>
      <div class="form-group"><label class="form-label">Doctor</label><input type="text" class="form-control" value="Dr. {{ $appointment->doctor->user->name ?? '' }}" disabled></div>
    </div>
    <div class="form-row cols-3">
      <div class="form-group"><label class="form-label">Date <span>*</span></label><input type="date" name="appointment_date" class="form-control" value="{{ old('appointment_date',$appointment->appointment_date->format('Y-m-d')) }}" required></div>
      <div class="form-group"><label class="form-label">Time <span>*</span></label><input type="time" name="appointment_time" class="form-control" value="{{ old('appointment_time',$appointment->appointment_time) }}" required></div>
      <div class="form-group"><label class="form-label">Type</label>
        <select name="type" class="form-select">
          @foreach(['consultation','follow_up','emergency','routine'] as $t)<option value="{{ $t }}" {{ old('type',$appointment->type)==$t?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$t)) }}</option>@endforeach
        </select>
      </div>
    </div>
    <div class="form-group"><label class="form-label">Status</label>
      <select name="status" class="form-select">
        @foreach(['pending','confirmed','completed','cancelled','no_show'] as $s)<option value="{{ $s }}" {{ old('status',$appointment->status)==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach
      </select>
    </div>
    <div class="form-group"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="3">{{ old('notes',$appointment->notes) }}</textarea></div>
    <div class="flex gap-3 justify-end">
      <a href="{{ route('appointments.show',$appointment) }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save Changes</button>
    </div>
  </div>
</div>
</form>
</div>
@endsection
