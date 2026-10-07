@extends('layouts.app')
@section('title','Laboratory')
@section('page-title','Laboratory')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Laboratory</span></div>
    <h1 class="page-title">Lab Tests</h1>
    <p class="page-subtitle">Manage lab test requests and results</p>
  </div>
  <a href="{{ route('lab.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Test Request</a>
</div>

<!-- Stats -->
<div class="grid grid-4 mb-6">
  <div class="card" style="padding:18px;"><div class="flex items-center gap-3"><div style="width:44px;height:44px;background:var(--primary-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary);"><i class="fas fa-flask"></i></div><div><div style="font-size:24px;font-weight:800;">{{ $stats['total'] }}</div><div style="font-size:12px;color:var(--gray-500);">Total Tests</div></div></div></div>
  <div class="card" style="padding:18px;"><div class="flex items-center gap-3"><div style="width:44px;height:44px;background:var(--warning-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--warning);"><i class="fas fa-hourglass-half"></i></div><div><div style="font-size:24px;font-weight:800;">{{ $stats['requested'] }}</div><div style="font-size:12px;color:var(--gray-500);">Requested</div></div></div></div>
  <div class="card" style="padding:18px;"><div class="flex items-center gap-3"><div style="width:44px;height:44px;background:var(--info-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--info);"><i class="fas fa-spinner"></i></div><div><div style="font-size:24px;font-weight:800;">{{ $stats['in_progress'] }}</div><div style="font-size:12px;color:var(--gray-500);">In Progress</div></div></div></div>
  <div class="card" style="padding:18px;"><div class="flex items-center gap-3"><div style="width:44px;height:44px;background:var(--success-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--success);"><i class="fas fa-check-circle"></i></div><div><div style="font-size:24px;font-weight:800;">{{ $stats['completed'] }}</div><div style="font-size:12px;color:var(--gray-500);">Completed</div></div></div></div>
</div>

<form method="GET" class="filter-bar">
  <div class="filter-search"><i class="fas fa-search"></i><input type="text" name="search" placeholder="Search patient, test name..." value="{{ request('search') }}"></div>
  <select name="status" class="filter-select" onchange="this.form.submit()">
    <option value="">All Status</option>
    @foreach(['requested','in_progress','completed','cancelled'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach
  </select>
  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i></button>
  @if(request()->hasAny(['search','status']))<a href="{{ route('lab.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i></a>@endif
</form>

<div class="card">
  <div class="table-wrapper" style="border:none;border-radius:0;">
    <table class="table">
      <thead><tr><th>Test #</th><th>Patient</th><th>Doctor</th><th>Test Name</th><th>Type</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($tests as $test)
        <tr>
          <td><code style="font-size:12px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $test->test_number }}</code></td>
          <td>
            <div style="font-weight:600;font-size:13px;">{{ $test->patient->full_name }}</div>
            <div style="font-size:11px;color:var(--gray-400);">{{ $test->patient->patient_id }}</div>
          </td>
          <td style="font-size:13px;">Dr. {{ $test->doctor->user->name ?? '—' }}</td>
          <td style="font-weight:600;font-size:13.5px;">{{ $test->test_name }}</td>
          <td><span style="background:var(--info-soft);color:var(--info);padding:3px 8px;border-radius:20px;font-size:12px;">{{ $test->test_type }}</span></td>
          <td style="font-weight:600;font-size:14px;">₦{{ number_format($test->price,2) }}</td>
          <td><span class="badge badge-{{ $test->status_color }}">{{ ucfirst(str_replace('_',' ',$test->status)) }}</span></td>
          <td><a href="{{ route('lab.show', $test) }}" class="btn btn-outline btn-icon btn-sm"><i class="fas fa-eye"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="8"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-flask"></i></div><h3>No lab tests</h3><a href="{{ route('lab.create') }}" class="btn btn-primary">Create Test Request</a></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $tests->links() }}</div>
</div>
@endsection
