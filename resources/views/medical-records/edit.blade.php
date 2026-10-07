@extends('layouts.app')
@section('title','Edit Medical Record')
@section('page-title','Edit Medical Record')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('medical-records.index') }}">Records</a><span>/</span><span>Edit</span></div>
    <h1 class="page-title">Edit Medical Record</h1>
  </div>
  <a href="{{ route('medical-records.show',$medicalRecord) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div style="max-width:760px;">
<form method="POST" action="{{ route('medical-records.update',$medicalRecord) }}">
@csrf @method('PUT')
<div class="card">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-file-medical" style="color:var(--primary);margin-right:8px;"></i>Clinical Information</h3></div>
  <div class="card-body">
    <div style="background:var(--gray-50);border-radius:8px;padding:12px;margin-bottom:18px;display:flex;gap:20px;">
      <div><span style="font-size:11px;text-transform:uppercase;font-weight:700;color:var(--gray-400);">Patient</span><p style="font-size:14px;font-weight:600;">{{ $medicalRecord->patient->full_name }}</p></div>
      <div><span style="font-size:11px;text-transform:uppercase;font-weight:700;color:var(--gray-400);">Doctor</span><p style="font-size:14px;font-weight:600;">Dr. {{ $medicalRecord->doctor->user->name??'—' }}</p></div>
      <div><span style="font-size:11px;text-transform:uppercase;font-weight:700;color:var(--gray-400);">Visit Date</span><p style="font-size:14px;font-weight:600;">{{ $medicalRecord->visit_date->format('M d, Y') }}</p></div>
    </div>
    <div class="form-group"><label class="form-label">Chief Complaint <span>*</span></label><textarea name="chief_complaint" class="form-control" rows="2" required>{{ old('chief_complaint',$medicalRecord->chief_complaint) }}</textarea></div>
    <div class="form-group"><label class="form-label">Diagnosis <span>*</span></label><textarea name="diagnosis" class="form-control" rows="3" required>{{ old('diagnosis',$medicalRecord->diagnosis) }}</textarea></div>
    <div class="form-group"><label class="form-label">Treatment Plan</label><textarea name="treatment_plan" class="form-control" rows="3">{{ old('treatment_plan',$medicalRecord->treatment_plan) }}</textarea></div>
    <div class="form-group"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes',$medicalRecord->notes) }}</textarea></div>
    <div class="form-row" style="grid-template-columns:repeat(5,1fr);gap:12px;">
      <div class="form-group"><label class="form-label">Weight</label><input type="number" name="weight" class="form-control" step="0.1" value="{{ old('weight',$medicalRecord->weight) }}"></div>
      <div class="form-group"><label class="form-label">Height</label><input type="number" name="height" class="form-control" step="0.1" value="{{ old('height',$medicalRecord->height) }}"></div>
      <div class="form-group"><label class="form-label">BP</label><input type="text" name="blood_pressure" class="form-control" placeholder="120/80" value="{{ old('blood_pressure',$medicalRecord->blood_pressure) }}"></div>
      <div class="form-group"><label class="form-label">Temp (°C)</label><input type="number" name="temperature" class="form-control" step="0.1" value="{{ old('temperature',$medicalRecord->temperature) }}"></div>
      <div class="form-group"><label class="form-label">Pulse</label><input type="number" name="pulse_rate" class="form-control" value="{{ old('pulse_rate',$medicalRecord->pulse_rate) }}"></div>
    </div>
    <div class="flex gap-3 justify-end mt-2">
      <a href="{{ route('medical-records.show',$medicalRecord) }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save Changes</button>
    </div>
  </div>
</div>
</form>
</div>
@endsection
