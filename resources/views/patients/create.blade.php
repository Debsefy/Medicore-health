@extends('layouts.app')
@section('title','Add Patient')
@section('page-title','Add New Patient')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('patients.index') }}">Patients</a><span>/</span><span>Add New</span></div>
    <h1 class="page-title">Add New Patient</h1>
  </div>
  <a href="{{ route('patients.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Patients</a>
</div>

<div style="max-width:900px;">
<form method="POST" action="{{ route('patients.store') }}" enctype="multipart/form-data">
@csrf

<div class="grid grid-12">

  <!-- Personal Info -->
  <div class="card col-8">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-user" style="color:var(--primary);margin-right:8px;"></i>Personal Information</h3></div>
    <div class="card-body">
      <div class="form-row cols-2">
        <div class="form-group">
          <label class="form-label">First Name <span>*</span></label>
          <input type="text" name="first_name" class="form-control {{ $errors->has('first_name') ? 'is-invalid':'' }}" value="{{ old('first_name') }}" placeholder="Jane" required>
          @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Last Name <span>*</span></label>
          <input type="text" name="last_name" class="form-control {{ $errors->has('last_name') ? 'is-invalid':'' }}" value="{{ old('last_name') }}" placeholder="Doe" required>
          @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-row cols-2">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="jane@example.com">
        </div>
        <div class="form-group">
          <label class="form-label">Phone Number <span>*</span></label>
          <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid':'' }}" value="{{ old('phone') }}" placeholder="+234 800 000 0000" required>
          @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-row cols-3">
        <div class="form-group">
          <label class="form-label">Date of Birth <span>*</span></label>
          <input type="date" name="date_of_birth" class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid':'' }}" value="{{ old('date_of_birth') }}" required>
          @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Gender <span>*</span></label>
          <select name="gender" class="form-select" required>
            <option value="">Select gender</option>
            <option value="male"   {{ old('gender')=='male'   ? 'selected':'' }}>Male</option>
            <option value="female" {{ old('gender')=='female' ? 'selected':'' }}>Female</option>
            <option value="other"  {{ old('gender')=='other'  ? 'selected':'' }}>Other</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Blood Type</label>
          <select name="blood_type" class="form-select">
            <option value="">Unknown</option>
            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
            <option value="{{ $bt }}" {{ old('blood_type')==$bt ? 'selected':'' }}>{{ $bt }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="2" placeholder="Street address, city, state...">{{ old('address') }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Known Allergies</label>
        <textarea name="allergies" class="form-control" rows="2" placeholder="List any known allergies (drugs, food, etc.)...">{{ old('allergies') }}</textarea>
      </div>
    </div>
  </div>

  <!-- Photo + Emergency Contact -->
  <div class="col-4" style="display:flex;flex-direction:column;gap:18px;">

    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-camera" style="color:var(--primary);margin-right:8px;"></i>Patient Photo</h3></div>
      <div class="card-body" style="text-align:center;">
        <div style="width:100px;height:100px;border-radius:50%;background:var(--gray-100);border:2px dashed var(--gray-300);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;overflow:hidden;">
          <img id="photoPreview" style="display:none;width:100%;height:100%;object-fit:cover;" alt="">
          <i class="fas fa-user" style="font-size:36px;color:var(--gray-300);" id="photoIcon"></i>
        </div>
        <label class="btn btn-outline btn-sm" style="cursor:pointer;">
          <i class="fas fa-upload"></i> Upload Photo
          <input type="file" name="photo" accept="image/*" style="display:none;" class="file-input-preview" data-preview="photoPreview" onchange="document.getElementById('photoIcon').style.display='none'">
        </label>
        <p class="form-text">JPG, PNG, max 2MB</p>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-phone-alt" style="color:var(--danger);margin-right:8px;"></i>Emergency Contact</h3></div>
      <div class="card-body">
        <div class="form-group">
          <label class="form-label">Contact Name</label>
          <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name') }}" placeholder="Full name">
        </div>
        <div class="form-group">
          <label class="form-label">Contact Phone</label>
          <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone') }}" placeholder="+234 800 000 0000">
        </div>
      </div>
    </div>

  </div>

  <!-- Actions -->
  <div class="col-12 flex gap-3 justify-end">
    <a href="{{ route('patients.index') }}" class="btn btn-outline">Cancel</a>
    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save Patient</button>
  </div>

</div>
</form>
</div>

@endsection
