@extends('layouts.app')
@section('title','Request Lab Test')
@section('page-title','New Lab Test Request')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('lab.index') }}">Lab</a><span>/</span><span>New Request</span></div>
    <h1 class="page-title">Lab Test Request</h1>
  </div>
  <a href="{{ route('lab.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:720px;">
<form method="POST" action="{{ route('lab.store') }}">
@csrf
<div class="card">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-flask" style="color:var(--info);margin-right:8px;"></i>Test Details</h3></div>
  <div class="card-body">

    <div class="form-row cols-2">
      <div class="form-group">
        <label class="form-label">Patient <span>*</span></label>
        <select name="patient_id" class="form-select" required>
          <option value="">— Select patient —</option>
          @foreach($patients as $p)<option value="{{ $p->id }}" {{ old('patient_id')==$p->id ? 'selected':'' }}>{{ $p->full_name }} ({{ $p->patient_id }})</option>@endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Requesting Doctor <span>*</span></label>
        <select name="doctor_id" class="form-select" required>
          <option value="">— Select doctor —</option>
          @foreach($doctors as $doc)<option value="{{ $doc->id }}" {{ old('doctor_id')==$doc->id ? 'selected':'' }}>Dr. {{ $doc->user->name }}</option>@endforeach
        </select>
      </div>
    </div>

    <div class="form-row cols-2">
      <div class="form-group">
        <label class="form-label">Test Name <span>*</span></label>
        <input type="text" name="test_name" class="form-control" list="testNames" placeholder="e.g. Complete Blood Count" value="{{ old('test_name') }}" required>
        <datalist id="testNames">
          @foreach(['Complete Blood Count (CBC)','Blood Glucose','Lipid Profile','Kidney Function Test','Liver Function Test','Urinalysis','HIV Test','Malaria Test','Pregnancy Test','Thyroid Function Test','Electrolytes','HbA1c','Blood Culture','Chest X-Ray','ECG'] as $t)
          <option value="{{ $t }}">@endforeach
        </datalist>
      </div>
      <div class="form-group">
        <label class="form-label">Test Type <span>*</span></label>
        <select name="test_type" class="form-select" required>
          <option value="">— Select type —</option>
          @foreach(['Hematology','Biochemistry','Microbiology','Serology','Urinalysis','Radiology','Cardiology','Pathology','Immunology'] as $t)<option value="{{ $t }}" {{ old('test_type')==$t ? 'selected':'' }}>{{ $t }}</option>@endforeach
        </select>
      </div>
    </div>

    <div class="form-row cols-2">
      <div class="form-group">
        <label class="form-label">Price (₦) <span>*</span></label>
        <input type="number" name="price" class="form-control" step="0.01" placeholder="0.00" value="{{ old('price') }}" required>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Special Instructions</label>
      <textarea name="instructions" class="form-control" rows="3" placeholder="Fasting required? Special preparation needed?">{{ old('instructions') }}</textarea>
    </div>

    <div class="flex gap-3 justify-end">
      <a href="{{ route('lab.index') }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-flask"></i> Submit Request</button>
    </div>
  </div>
</div>
</form>
</div>
@endsection
