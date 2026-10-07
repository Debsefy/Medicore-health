@extends('layouts.app')
@section('title','Patients')
@section('page-title','Patient Management')

@section('content')

<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Patients</span></div>
    <h1 class="page-title">Patients</h1>
    <p class="page-subtitle">{{ $patients->total() }} total patients in the system</p>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('patients.create') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add Patient</a>
  </div>
</div>

<!-- Filter Bar -->
<form method="GET" class="filter-bar">
  <div class="filter-search">
    <i class="fas fa-search"></i>
    <input type="text" name="search" placeholder="Search by name, ID, phone..." value="{{ request('search') }}">
  </div>
  <select name="status" class="filter-select" onchange="this.form.submit()">
    <option value="">All Status</option>
    <option value="active"   {{ request('status')=='active'   ? 'selected':'' }}>Active</option>
    <option value="inactive" {{ request('status')=='inactive' ? 'selected':'' }}>Inactive</option>
    <option value="deceased" {{ request('status')=='deceased' ? 'selected':'' }}>Deceased</option>
  </select>
  <select name="gender" class="filter-select" onchange="this.form.submit()">
    <option value="">All Gender</option>
    <option value="male"   {{ request('gender')=='male'   ? 'selected':'' }}>Male</option>
    <option value="female" {{ request('gender')=='female' ? 'selected':'' }}>Female</option>
    <option value="other"  {{ request('gender')=='other'  ? 'selected':'' }}>Other</option>
  </select>
  <select name="blood_type" class="filter-select" onchange="this.form.submit()">
    <option value="">Blood Type</option>
    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
    <option value="{{ $bt }}" {{ request('blood_type')==$bt ? 'selected':'' }}>{{ $bt }}</option>
    @endforeach
  </select>
  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
  @if(request()->hasAny(['search','status','gender','blood_type']))
    <a href="{{ route('patients.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Clear</a>
  @endif
</form>

@if($patients->isEmpty())
  <div class="card">
    <div class="empty-state">
      <div class="empty-state-icon"><i class="fas fa-user-injured"></i></div>
      <h3>No patients found</h3>
      <p>Start by adding your first patient to the system.</p>
      <a href="{{ route('patients.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add First Patient</a>
    </div>
  </div>
@else
<div class="card">
  <div class="table-wrapper" style="border:none;border-radius:0;">
    <table class="table">
      <thead>
        <tr>
          <th>Patient</th>
          <th>ID</th>
          <th>Date of Birth</th>
          <th>Gender</th>
          <th>Blood Type</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($patients as $patient)
        <tr class="searchable-row">
          <td>
            <div class="flex items-center gap-3">
              @if($patient->photo)
                <img src="{{ asset('storage/'.$patient->photo) }}" alt="" style="width:38px;height:38px;border-radius:50%;object-fit:cover;">
              @else
                <div class="avatar avatar-sm" style="background:linear-gradient(135deg,{{ ['#0f6fff','#10b981','#f59e0b','#ef4444','#6366f1'][($patient->id % 5)] }},{{ ['#06b6d4','#34d399','#fbbf24','#f87171','#818cf8'][($patient->id % 5)] }})">
                  {{ strtoupper(substr($patient->first_name,0,2)) }}
                </div>
              @endif
              <div>
                <div style="font-weight:600;font-size:13.5px;">{{ $patient->full_name }}</div>
                <div style="font-size:11px;color:var(--gray-400)">{{ $patient->email ?? 'No email' }}</div>
              </div>
            </div>
          </td>
          <td><code style="font-size:12px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $patient->patient_id }}</code></td>
          <td style="font-size:13px;">
            {{ $patient->date_of_birth->format('M d, Y') }}
            <div style="font-size:11px;color:var(--gray-400)">Age {{ $patient->age }}</div>
          </td>
          <td style="text-transform:capitalize;font-size:13px;">{{ $patient->gender }}</td>
          <td>
            @if($patient->blood_type)
              <span style="background:var(--danger-soft);color:var(--danger);padding:3px 8px;border-radius:20px;font-size:12px;font-weight:700;">{{ $patient->blood_type }}</span>
            @else
              <span style="color:var(--gray-300);">—</span>
            @endif
          </td>
          <td style="font-size:13px;">{{ $patient->phone }}</td>
          <td><span class="badge badge-{{ $patient->status_color }}">{{ ucfirst($patient->status) }}</span></td>
          <td>
            <div class="table-actions">
              <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline btn-icon btn-sm" title="View"><i class="fas fa-eye"></i></a>
              <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline btn-icon btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{ route('patients.destroy', $patient) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-icon btn-sm" data-confirm="Delete {{ $patient->full_name }}?" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $patients->links() }}
  </div>
</div>
@endif

@endsection
