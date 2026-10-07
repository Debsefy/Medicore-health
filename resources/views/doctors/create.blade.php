@extends('layouts.app')
@section('title','Add Doctor')
@section('page-title','Add New Doctor')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('doctors.index') }}">Doctors</a><span>/</span><span>Add New</span></div>
    <h1 class="page-title">Add New Doctor</h1>
  </div>
  <a href="{{ route('doctors.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:860px;">
<form method="POST" action="{{ route('doctors.store') }}">
@csrf
<div class="card">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-user-md" style="color:var(--primary);margin-right:8px;"></i>Doctor Information</h3></div>
  <div class="card-body">

    <div style="padding:14px;background:var(--info-soft);border-radius:8px;margin-bottom:20px;font-size:13px;color:var(--info);"><i class="fas fa-info-circle"></i> A user account will be created for the doctor automatically.</div>

    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Full Name <span>*</span></label><input type="text" name="name" class="form-control" placeholder="Dr. John Smith" value="{{ old('name') }}" required></div>
      <div class="form-group"><label class="form-label">Email <span>*</span></label><input type="email" name="email" class="form-control" placeholder="doctor@hospital.com" value="{{ old('email') }}" required></div>
    </div>
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Phone <span>*</span></label><input type="text" name="phone" class="form-control" placeholder="+234 800 000 0000" value="{{ old('phone') }}" required></div>
      <div class="form-group"><label class="form-label">License Number</label><input type="text" name="license_number" class="form-control" placeholder="e.g. MDCN-2024-001" value="{{ old('license_number') }}"></div>
    </div>
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Specialization <span>*</span></label><input type="text" name="specialization" class="form-control" list="specializations" placeholder="e.g. Cardiology" value="{{ old('specialization') }}" required>
        <datalist id="specializations">@foreach(['Cardiology','Neurology','Orthopedics','Pediatrics','Gynecology','Dermatology','Ophthalmology','ENT','Psychiatry','Oncology','Urology','Gastroenterology','General Practice','Surgery','Dentistry','Radiology'] as $s)<option value="{{ $s }}">@endforeach</datalist>
      </div>
      <div class="form-group"><label class="form-label">Qualification <span>*</span></label><input type="text" name="qualification" class="form-control" placeholder="e.g. MBBS, MD, FMCP" value="{{ old('qualification') }}" required></div>
    </div>
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Years of Experience</label><input type="number" name="experience_years" class="form-control" min="0" value="{{ old('experience_years',0) }}"></div>
      <div class="form-group"><label class="form-label">Consultation Fee (₦) <span>*</span></label><input type="number" name="consultation_fee" class="form-control" step="0.01" value="{{ old('consultation_fee',0) }}" required></div>
    </div>

    <div class="form-group">
      <label class="form-label">Available Days</label>
      <div class="flex gap-3 flex-wrap">
        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
        <label class="flex items-center gap-2" style="cursor:pointer;">
          <input type="checkbox" name="available_days[]" value="{{ $day }}" {{ in_array($day, old('available_days',[])) ? 'checked':'' }} style="width:16px;height:16px;accent-color:var(--primary);">
          <span style="font-size:13px;">{{ $day }}</span>
        </label>
        @endforeach
      </div>
    </div>

    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Available From</label><input type="time" name="available_from" class="form-control" value="{{ old('available_from','08:00') }}"></div>
      <div class="form-group"><label class="form-label">Available To</label><input type="time" name="available_to" class="form-control" value="{{ old('available_to','17:00') }}"></div>
    </div>

    <div class="form-group"><label class="form-label">Bio / About</label><textarea name="bio" class="form-control" rows="3" placeholder="Brief professional biography...">{{ old('bio') }}</textarea></div>

    <hr style="border-color:var(--gray-200);margin:20px 0;">
    <div style="font-size:14px;font-weight:700;color:var(--gray-700);margin-bottom:14px;"><i class="fas fa-lock" style="color:var(--primary);margin-right:6px;"></i>Account Credentials</div>
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Password <span>*</span></label><input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required></div>
      <div class="form-group"><label class="form-label">Confirm Password <span>*</span></label><input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required></div>
    </div>

    <div class="flex gap-3 justify-end mt-4">
      <a href="{{ route('doctors.index') }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-user-md"></i> Add Doctor</button>
    </div>
  </div>
</div>
</form>
</div>
@endsection
