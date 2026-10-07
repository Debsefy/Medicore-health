@extends('layouts.app')
@section('title','Add Medical Record')
@section('page-title','New Medical Record')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('medical-records.index') }}">Medical Records</a><span>/</span><span>New</span></div>
    <h1 class="page-title">New Medical Record</h1>
  </div>
  <a href="{{ route('medical-records.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('medical-records.store') }}">
@csrf
<div class="grid grid-12">

  <div class="col-8" style="display:flex;flex-direction:column;gap:18px;">
    <!-- Visit Info -->
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-stethoscope" style="color:var(--primary);margin-right:8px;"></i>Visit Information</h3></div>
      <div class="card-body">
        <div class="form-row cols-3">
          <div class="form-group">
            <label class="form-label">Patient <span>*</span></label>
            <select name="patient_id" class="form-select" required>
              <option value="">— Select —</option>
              @foreach($patients as $p)
              <option value="{{ $p->id }}" {{ (request('patient_id')==$p->id || old('patient_id')==$p->id || ($selectedPatient && $selectedPatient->id==$p->id)) ? 'selected':'' }}>{{ $p->full_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Doctor <span>*</span></label>
            <select name="doctor_id" class="form-select" required>
              <option value="">— Select —</option>
              @foreach($doctors as $doc)
              <option value="{{ $doc->id }}" {{ old('doctor_id')==$doc->id ? 'selected':'' }}>Dr. {{ $doc->user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Visit Date <span>*</span></label>
            <input type="date" name="visit_date" class="form-control today-default" value="{{ old('visit_date') }}" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Chief Complaint <span>*</span></label>
          <textarea name="chief_complaint" class="form-control" rows="2" placeholder="Patient's primary complaint..." required>{{ old('chief_complaint') }}</textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Diagnosis <span>*</span></label>
          <textarea name="diagnosis" class="form-control" rows="3" placeholder="Clinical diagnosis..." required>{{ old('diagnosis') }}</textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Treatment Plan</label>
          <textarea name="treatment_plan" class="form-control" rows="3" placeholder="Recommended treatment plan...">{{ old('treatment_plan') }}</textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Doctor's Notes</label>
          <textarea name="notes" class="form-control" rows="2" placeholder="Additional notes...">{{ old('notes') }}</textarea>
        </div>
      </div>
    </div>

    <!-- Vitals -->
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-heartbeat" style="color:var(--danger);margin-right:8px;"></i>Vital Signs</h3></div>
      <div class="card-body">
        <div class="form-row cols-5" style="grid-template-columns:repeat(5,1fr);">
          <div class="form-group">
            <label class="form-label">Weight (kg)</label>
            <input type="number" name="weight" class="form-control" step="0.1" placeholder="70.5" value="{{ old('weight') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Height (cm)</label>
            <input type="number" name="height" class="form-control" step="0.1" placeholder="170" value="{{ old('height') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Blood Pressure</label>
            <input type="text" name="blood_pressure" class="form-control" placeholder="120/80" value="{{ old('blood_pressure') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Temperature (°C)</label>
            <input type="number" name="temperature" class="form-control" step="0.1" placeholder="37.0" value="{{ old('temperature') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Pulse (bpm)</label>
            <input type="number" name="pulse_rate" class="form-control" placeholder="72" value="{{ old('pulse_rate') }}">
          </div>
        </div>
      </div>
    </div>

    <!-- Prescriptions -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-prescription-bottle-alt" style="color:var(--warning);margin-right:8px;"></i>Prescriptions</h3>
        <button type="button" id="addMedRow" class="btn btn-outline btn-sm"><i class="fas fa-plus"></i> Add Medication</button>
      </div>
      <div class="card-body">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1.5fr 36px;gap:8px;margin-bottom:8px;">
          <span style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-500);">Drug Name</span>
          <span style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-500);">Dosage</span>
          <span style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-500);">Frequency</span>
          <span style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-500);">Duration</span>
          <span></span>
        </div>
        <div id="medRowsContainer">
          <div class="med-row" style="display:grid;grid-template-columns:2fr 1fr 1fr 1.5fr 36px;gap:8px;margin-bottom:8px;">
            <input type="text"   name="medications[0][name]"      class="form-control" placeholder="e.g. Amoxicillin">
            <input type="text"   name="medications[0][dosage]"    class="form-control" placeholder="500mg">
            <input type="text"   name="medications[0][frequency]" class="form-control" placeholder="3× daily">
            <input type="text"   name="medications[0][duration]"  class="form-control" placeholder="7 days">
            <button type="button" class="btn btn-ghost btn-icon remove-med" style="color:var(--danger);"><i class="fas fa-minus-circle"></i></button>
          </div>
        </div>
        <div class="form-group mt-3">
          <label class="form-label">Prescription Notes</label>
          <textarea name="prescription_notes" class="form-control" rows="2" placeholder="Special instructions..."></textarea>
        </div>
      </div>
    </div>

  </div>

  <div class="col-4">
    <div class="card sticky" style="position:sticky;top:80px;">
      <div class="card-header"><h3 class="card-title">Save Record</h3></div>
      <div class="card-body">
        @if(request('appointment_id'))
          <input type="hidden" name="appointment_id" value="{{ request('appointment_id') }}">
          <div class="alert alert-info" style="margin-bottom:16px;"><i class="fas fa-info-circle"></i> Linked to appointment #{{ request('appointment_id') }}</div>
        @endif
        <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">Complete all required fields and save this medical record. Linked appointments will be marked as completed.</p>
        <button type="submit" class="btn btn-primary btn-lg w-full" style="justify-content:center;"><i class="fas fa-save"></i> Save Medical Record</button>
        <a href="{{ route('medical-records.index') }}" class="btn btn-outline w-full mt-2" style="justify-content:center;">Cancel</a>
      </div>
    </div>
  </div>

</div>
</form>
@endsection
