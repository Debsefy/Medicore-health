@extends('layouts.app')
@section('title','Edit Patient')
@section('page-title','Edit Patient')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('patients.index') }}">Patients</a><span>/</span><a href="{{ route('patients.show',$patient) }}">{{ $patient->full_name }}</a><span>/</span><span>Edit</span></div>
    <h1 class="page-title">Edit — {{ $patient->full_name }}</h1>
  </div>
  <a href="{{ route('patients.show',$patient) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:900px;">
<form method="POST" action="{{ route('patients.update',$patient) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="grid grid-12">
  <div class="card col-8">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-user" style="color:var(--primary);margin-right:8px;"></i>Personal Information</h3></div>
    <div class="card-body">
      <div class="form-row cols-2">
        <div class="form-group"><label class="form-label">First Name <span>*</span></label><input type="text" name="first_name" class="form-control {{ $errors->has('first_name')?'is-invalid':'' }}" value="{{ old('first_name',$patient->first_name) }}" required>@error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-group"><label class="form-label">Last Name <span>*</span></label><input type="text" name="last_name" class="form-control {{ $errors->has('last_name')?'is-invalid':'' }}" value="{{ old('last_name',$patient->last_name) }}" required>@error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
      </div>
      <div class="form-row cols-2">
        <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$patient->email) }}"></div>
        <div class="form-group"><label class="form-label">Phone <span>*</span></label><input type="text" name="phone" class="form-control" value="{{ old('phone',$patient->phone) }}" required></div>
      </div>
      <div class="form-row cols-3">
        <div class="form-group"><label class="form-label">Date of Birth <span>*</span></label><input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth',$patient->date_of_birth->format('Y-m-d')) }}" required></div>
        <div class="form-group"><label class="form-label">Gender <span>*</span></label>
          <select name="gender" class="form-select" required>
            @foreach(['male','female','other'] as $g)<option value="{{ $g }}" {{ old('gender',$patient->gender)==$g?'selected':'' }}>{{ ucfirst($g) }}</option>@endforeach
          </select>
        </div>
        <div class="form-group"><label class="form-label">Blood Type</label>
          <select name="blood_type" class="form-select">
            <option value="">Unknown</option>
            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)<option value="{{ $bt }}" {{ old('blood_type',$patient->blood_type)==$bt?'selected':'' }}>{{ $bt }}</option>@endforeach
          </select>
        </div>
      </div>
      <div class="form-group"><label class="form-label">Status</label>
        <select name="status" class="form-select">
          @foreach(['active','inactive','deceased'] as $s)<option value="{{ $s }}" {{ old('status',$patient->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address',$patient->address) }}</textarea></div>
      <div class="form-group"><label class="form-label">Known Allergies</label><textarea name="allergies" class="form-control" rows="2">{{ old('allergies',$patient->allergies) }}</textarea></div>
    </div>
  </div>
  <div class="col-4" style="display:flex;flex-direction:column;gap:18px;">
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-camera" style="color:var(--primary);margin-right:8px;"></i>Photo</h3></div>
      <div class="card-body" style="text-align:center;">
        <div style="width:100px;height:100px;border-radius:50%;background:var(--gray-100);border:2px dashed var(--gray-300);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;overflow:hidden;">
          @if($patient->photo)
            <img id="photoPreview" src="{{ asset('storage/'.$patient->photo) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
          @else
            <img id="photoPreview" style="display:none;width:100%;height:100%;object-fit:cover;" alt=""><i class="fas fa-user" style="font-size:36px;color:var(--gray-300);" id="photoIcon"></i>
          @endif
        </div>
        <label class="btn btn-outline btn-sm" style="cursor:pointer;"><i class="fas fa-upload"></i> Change Photo<input type="file" name="photo" accept="image/*" style="display:none;" class="file-input-preview" data-preview="photoPreview" onchange="document.getElementById('photoIcon')&&(document.getElementById('photoIcon').style.display='none')"></label>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-phone-alt" style="color:var(--danger);margin-right:8px;"></i>Emergency Contact</h3></div>
      <div class="card-body">
        <div class="form-group"><label class="form-label">Name</label><input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name',$patient->emergency_contact_name) }}"></div>
        <div class="form-group"><label class="form-label">Phone</label><input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone',$patient->emergency_contact_phone) }}"></div>
      </div>
    </div>
  </div>
  <div class="col-12 flex gap-3 justify-end">
    <a href="{{ route('patients.show',$patient) }}" class="btn btn-outline">Cancel</a>
    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save Changes</button>
  </div>
</div>
</form>
</div>
@endsection
