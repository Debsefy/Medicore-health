@extends('layouts.app')
@section('title','Medical Records')
@section('page-title','Medical Records')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Medical Records</span></div>
    <h1 class="page-title">Medical Records</h1>
    <p class="page-subtitle">{{ $records->total() }} total records</p>
  </div>
  <a href="{{ route('medical-records.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Record</a>
</div>

<form method="GET" class="filter-bar">
  <div class="filter-search">
    <i class="fas fa-search"></i>
    <input type="text" name="search" placeholder="Search patient name..." value="{{ request('search') }}">
  </div>
  <select name="doctor_id" class="filter-select" onchange="this.form.submit()">
    <option value="">All Doctors</option>
    @foreach($doctors as $doc)<option value="{{ $doc->id }}" {{ request('doctor_id')==$doc->id ? 'selected':'' }}>Dr. {{ $doc->user->name }}</option>@endforeach
  </select>
  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
  @if(request()->hasAny(['search','doctor_id']))<a href="{{ route('medical-records.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i></a>@endif
</form>

<div class="card">
  <div class="table-wrapper" style="border:none;border-radius:0;">
    <table class="table">
      <thead>
        <tr><th>Patient</th><th>Doctor</th><th>Visit Date</th><th>Chief Complaint</th><th>Diagnosis</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($records as $record)
        <tr>
          <td>
            <div class="flex items-center gap-2">
              <div class="avatar avatar-sm">{{ strtoupper(substr($record->patient->first_name,0,2)) }}</div>
              <div>
                <div style="font-weight:600;font-size:13px;">{{ $record->patient->full_name }}</div>
                <div style="font-size:11px;color:var(--gray-400)">{{ $record->patient->patient_id }}</div>
              </div>
            </div>
          </td>
          <td style="font-size:13px;">Dr. {{ $record->doctor->user->name ?? '—' }}</td>
          <td style="font-size:13px;font-weight:500;">{{ $record->visit_date->format('M d, Y') }}</td>
          <td style="font-size:13px;max-width:200px;" class="truncate">{{ $record->chief_complaint }}</td>
          <td style="font-size:13px;max-width:200px;" class="truncate">{{ $record->diagnosis }}</td>
          <td><div class="table-actions">
            <a href="{{ route('medical-records.show', $record) }}" class="btn btn-outline btn-icon btn-sm"><i class="fas fa-eye"></i></a>
            <a href="{{ route('medical-records.edit', $record) }}" class="btn btn-outline btn-icon btn-sm"><i class="fas fa-edit"></i></a>
          </div></td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-file-medical"></i></div><h3>No records yet</h3><a href="{{ route('medical-records.create') }}" class="btn btn-primary">Add Record</a></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $records->links() }}</div>
</div>
@endsection
