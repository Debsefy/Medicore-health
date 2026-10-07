@extends('layouts.app')
@section('title','Lab Test')
@section('page-title','Lab Test Detail')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('lab.index') }}">Lab</a><span>/</span><span>{{ $lab->test_number }}</span></div>
    <h1 class="page-title">{{ $lab->test_name }}</h1>
    <p class="page-subtitle">{{ $lab->test_number }}</p>
  </div>
  <span class="badge badge-{{ $lab->status_color }}" style="font-size:14px;padding:6px 14px;">{{ ucfirst(str_replace('_',' ',$lab->status)) }}</span>
</div>

<div class="grid grid-12">
  <div class="col-8" style="display:flex;flex-direction:column;gap:18px;">
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-flask" style="color:var(--info);margin-right:8px;"></i>Test Information</h3></div>
      <div class="card-body">
        <div class="grid grid-2 gap-4 mb-4">
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);">Test Name</label><p style="font-size:15px;font-weight:700;margin-top:4px;">{{ $lab->test_name }}</p></div>
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);">Test Type</label><p style="font-size:15px;font-weight:600;margin-top:4px;">{{ $lab->test_type }}</p></div>
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);">Price</label><p style="font-size:15px;font-weight:700;color:var(--primary);margin-top:4px;">₦{{ number_format($lab->price,2) }}</p></div>
          <div><label style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray-400);">Requested On</label><p style="font-size:15px;font-weight:600;margin-top:4px;">{{ $lab->created_at->format('M d, Y') }}</p></div>
        </div>
        @if($lab->instructions)
        <div style="background:var(--info-soft);border-radius:8px;padding:14px;margin-bottom:12px;">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--info);margin-bottom:6px;"><i class="fas fa-info-circle"></i> Instructions</div>
          <p style="font-size:14px;color:var(--gray-700);">{{ $lab->instructions }}</p>
        </div>
        @endif
      </div>
    </div>

    <!-- Update Form (for lab technician) -->
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-edit" style="color:var(--success);margin-right:8px;"></i>Update Test Result</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('lab.update', $lab) }}" enctype="multipart/form-data">
          @csrf @method('PUT')
          <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              @foreach(['requested','in_progress','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ $lab->status==$s ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Test Result</label>
            <textarea name="result" class="form-control" rows="5" placeholder="Enter the lab test results here...">{{ old('result', $lab->result) }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Upload Report File (PDF/Image)</label>
            <input type="file" name="report_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            @if($lab->report_file)<p class="form-text"><i class="fas fa-paperclip"></i> Existing file: {{ basename($lab->report_file) }}</p>@endif
          </div>
          <div class="flex justify-end">
            <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Save Result</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-4" style="display:flex;flex-direction:column;gap:16px;">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Patient</h3></div>
      <div class="card-body">
        <div class="flex items-center gap-3 mb-3">
          <div class="avatar">{{ strtoupper(substr($lab->patient->first_name,0,2)) }}</div>
          <div><div style="font-weight:700;">{{ $lab->patient->full_name }}</div><div style="font-size:12px;color:var(--gray-400);">{{ $lab->patient->patient_id }}</div></div>
        </div>
        <div style="font-size:13px;color:var(--gray-600);margin-bottom:12px;"><i class="fas fa-phone" style="color:var(--primary);width:16px;"></i> {{ $lab->patient->phone }}</div>
        <a href="{{ route('patients.show', $lab->patient) }}" class="btn btn-outline btn-sm w-full" style="justify-content:center;">View Patient</a>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3 class="card-title">Requesting Doctor</h3></div>
      <div class="card-body">
        <div class="flex items-center gap-3">
          <div class="avatar" style="background:linear-gradient(135deg,var(--success),#34d399);">{{ strtoupper(substr($lab->doctor->user->name ?? 'D',0,2)) }}</div>
          <div><div style="font-weight:700;">Dr. {{ $lab->doctor->user->name ?? '—' }}</div><div style="font-size:12px;color:var(--gray-400);">{{ $lab->doctor->specialization }}</div></div>
        </div>
      </div>
    </div>

    @if($lab->completed_at)
    <div class="card" style="border-left:4px solid var(--success);">
      <div class="card-body">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--success);margin-bottom:6px;"><i class="fas fa-check-circle"></i> Completed</div>
        <p style="font-size:14px;font-weight:600;">{{ $lab->completed_at->format('M d, Y h:i A') }}</p>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
