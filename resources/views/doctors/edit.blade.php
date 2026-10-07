@extends('layouts.app')
@section('title','Edit Doctor')
@section('page-title','Edit Doctor')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('doctors.index') }}">Doctors</a><span>/</span><span>Edit</span></div>
    <h1 class="page-title">Edit Dr. {{ $doctor->user->name ?? '' }}</h1>
  </div>
  <a href="{{ route('doctors.show',$doctor) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div style="max-width:860px;">
<form method="POST" action="{{ route('doctors.update',$doctor) }}">
@csrf @method('PUT')
<div class="card">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-user-md" style="color:var(--primary);margin-right:8px;"></i>Doctor Details</h3></div>
  <div class="card-body">
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" class="form-control" value="{{ old('name',$doctor->user->name) }}"></div>
      <div class="form-group"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$doctor->user->phone) }}"></div>
    </div>
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Specialization <span>*</span></label><input type="text" name="specialization" class="form-control" value="{{ old('specialization',$doctor->specialization) }}" required></div>
      <div class="form-group"><label class="form-label">Qualification <span>*</span></label><input type="text" name="qualification" class="form-control" value="{{ old('qualification',$doctor->qualification) }}" required></div>
    </div>
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Experience (years)</label><input type="number" name="experience_years" class="form-control" min="0" value="{{ old('experience_years',$doctor->experience_years) }}"></div>
      <div class="form-group"><label class="form-label">Consultation Fee (₦)</label><input type="number" name="consultation_fee" class="form-control" step="0.01" value="{{ old('consultation_fee',$doctor->consultation_fee) }}"></div>
    </div>
    <div class="form-group">
      <label class="form-label">Available Days</label>
      <div class="flex gap-3 flex-wrap">
        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
        <label class="flex items-center gap-2" style="cursor:pointer;">
          <input type="checkbox" name="available_days[]" value="{{ $day }}" {{ in_array($day,old('available_days',$doctor->available_days??[]))?'checked':'' }} style="width:16px;height:16px;accent-color:var(--primary);">
          <span style="font-size:13px;">{{ $day }}</span>
        </label>
        @endforeach
      </div>
    </div>
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Available From</label><input type="time" name="available_from" class="form-control" value="{{ old('available_from',$doctor->available_from) }}"></div>
      <div class="form-group"><label class="form-label">Available To</label><input type="time" name="available_to" class="form-control" value="{{ old('available_to',$doctor->available_to) }}"></div>
    </div>
    <div class="form-group"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="3">{{ old('bio',$doctor->bio) }}</textarea></div>
    <div class="form-group">
      <label class="flex items-center gap-2" style="cursor:pointer;">
        <input type="checkbox" name="is_available" value="1" {{ old('is_available',$doctor->is_available)?'checked':'' }} style="width:16px;height:16px;accent-color:var(--primary);">
        <span style="font-size:14px;font-weight:600;">Doctor is currently available</span>
      </label>
    </div>
    <div class="flex gap-3 justify-end">
      <a href="{{ route('doctors.show',$doctor) }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save Changes</button>
    </div>
  </div>
</div>
</form>
</div>
@endsection
