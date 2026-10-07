@extends('layouts.app')
@section('title','Medical Record')
@section('page-title','Medical Record')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('medical-records.index') }}">Records</a><span>/</span><span>Detail</span></div>
    <h1 class="page-title">Medical Record — {{ $medicalRecord->visit_date->format('M d, Y') }}</h1>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('medical-records.edit', $medicalRecord) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Edit</a>
    <button onclick="window.print()" class="btn btn-primary" id="printBtn"><i class="fas fa-print"></i> Print</button>
  </div>
</div>

<div class="grid grid-12">
  <div class="col-8" style="display:flex;flex-direction:column;gap:18px;">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-medical" style="color:var(--primary);margin-right:8px;"></i>Clinical Information</h3>
        <span style="font-size:13px;color:var(--gray-500);">Visit: {{ $medicalRecord->visit_date->format('l, MMMM d, Y') }}</span>
      </div>
      <div class="card-body">
        <div style="display:grid;gap:18px;">
          <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-400);margin-bottom:6px;">Chief Complaint</div>
            <p style="font-size:14px;color:var(--gray-800);">{{ $medicalRecord->chief_complaint }}</p>
          </div>
          <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-400);margin-bottom:6px;">Diagnosis</div>
            <p style="font-size:14px;color:var(--gray-800);background:var(--primary-light);padding:12px;border-radius:8px;border-left:3px solid var(--primary);">{{ $medicalRecord->diagnosis }}</p>
          </div>
          @if($medicalRecord->treatment_plan)
          <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-400);margin-bottom:6px;">Treatment Plan</div>
            <p style="font-size:14px;color:var(--gray-800);">{{ $medicalRecord->treatment_plan }}</p>
          </div>
          @endif
          @if($medicalRecord->notes)
          <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-400);margin-bottom:6px;">Doctor's Notes</div>
            <p style="font-size:14px;color:var(--gray-600);">{{ $medicalRecord->notes }}</p>
          </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Vitals -->
    @if($medicalRecord->weight || $medicalRecord->blood_pressure || $medicalRecord->temperature)
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-heartbeat" style="color:var(--danger);margin-right:8px;"></i>Vital Signs</h3></div>
      <div class="card-body">
        <div class="vitals-grid">
          @if($medicalRecord->weight)<div class="vital-item"><div class="vital-icon"><i class="fas fa-weight"></i></div><div class="vital-value">{{ $medicalRecord->weight }}</div><div class="vital-label">Weight (kg)</div></div>@endif
          @if($medicalRecord->height)<div class="vital-item"><div class="vital-icon"><i class="fas fa-ruler-vertical"></i></div><div class="vital-value">{{ $medicalRecord->height }}</div><div class="vital-label">Height (cm)</div></div>@endif
          @if($medicalRecord->blood_pressure)<div class="vital-item"><div class="vital-icon"><i class="fas fa-heartbeat"></i></div><div class="vital-value">{{ $medicalRecord->blood_pressure }}</div><div class="vital-label">BP (mmHg)</div></div>@endif
          @if($medicalRecord->temperature)<div class="vital-item"><div class="vital-icon"><i class="fas fa-thermometer-half"></i></div><div class="vital-value">{{ $medicalRecord->temperature }}°</div><div class="vital-label">Temperature</div></div>@endif
          @if($medicalRecord->pulse_rate)<div class="vital-item"><div class="vital-icon"><i class="fas fa-heart"></i></div><div class="vital-value">{{ $medicalRecord->pulse_rate }}</div><div class="vital-label">Pulse (bpm)</div></div>@endif
          @if($medicalRecord->bmi)<div class="vital-item"><div class="vital-icon"><i class="fas fa-calculator"></i></div><div class="vital-value">{{ $medicalRecord->bmi }}</div><div class="vital-label">BMI</div></div>@endif
        </div>
      </div>
    </div>
    @endif

    <!-- Prescriptions -->
    @forelse($medicalRecord->prescriptions as $rx)
    <div class="card" style="border-left:4px solid var(--warning);">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-prescription-bottle-alt" style="color:var(--warning);margin-right:8px;"></i>Prescription — {{ $rx->prescription_number }}</h3>
        <span class="badge badge-{{ ['pending'=>'warning','dispensed'=>'success','cancelled'=>'danger'][$rx->status] ?? 'secondary' }}">{{ ucfirst($rx->status) }}</span>
      </div>
      <div class="card-body">
        <div class="table-wrapper" style="border:none;border-radius:0;">
          <table class="table">
            <thead><tr><th>#</th><th>Medication</th><th>Dosage</th><th>Frequency</th><th>Duration</th></tr></thead>
            <tbody>
              @foreach($rx->medications as $i => $med)
              <tr>
                <td style="font-size:13px;">{{ $i+1 }}</td>
                <td style="font-weight:600;font-size:14px;">{{ $med['name'] ?? '' }}</td>
                <td style="font-size:13px;">{{ $med['dosage'] ?? '' }}</td>
                <td style="font-size:13px;">{{ $med['frequency'] ?? '' }}</td>
                <td style="font-size:13px;">{{ $med['duration'] ?? '' }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if($rx->notes)<p style="font-size:13px;color:var(--gray-600);margin-top:12px;padding:10px;background:var(--gray-50);border-radius:6px;"><i class="fas fa-info-circle"></i> {{ $rx->notes }}</p>@endif
      </div>
    </div>
    @empty @endforelse

    <!-- Lab Tests -->
    @if($medicalRecord->labTests->count() > 0)
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-flask" style="color:var(--info);margin-right:8px;"></i>Lab Tests</h3></div>
      <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
          <thead><tr><th>Test #</th><th>Test Name</th><th>Type</th><th>Status</th><th>Result</th></tr></thead>
          <tbody>
            @foreach($medicalRecord->labTests as $test)
            <tr>
              <td><code style="font-size:12px;">{{ $test->test_number }}</code></td>
              <td style="font-weight:600;font-size:13px;">{{ $test->test_name }}</td>
              <td style="font-size:12px;">{{ $test->test_type }}</td>
              <td><span class="badge badge-{{ $test->status_color }}">{{ ucfirst(str_replace('_',' ',$test->status)) }}</span></td>
              <td style="font-size:13px;">{{ $test->result ? Str::limit($test->result, 60) : '—' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

  </div>

  <div class="col-4" style="display:flex;flex-direction:column;gap:16px;">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Patient</h3></div>
      <div class="card-body">
        <div class="flex items-center gap-3 mb-3">
          <div class="avatar">{{ strtoupper(substr($medicalRecord->patient->first_name,0,2)) }}</div>
          <div>
            <div style="font-weight:700;">{{ $medicalRecord->patient->full_name }}</div>
            <div style="font-size:12px;color:var(--gray-400);">{{ $medicalRecord->patient->patient_id }}</div>
          </div>
        </div>
        <div style="font-size:13px;color:var(--gray-600);display:flex;flex-direction:column;gap:6px;">
          <span><i class="fas fa-phone" style="color:var(--primary);width:16px;"></i> {{ $medicalRecord->patient->phone }}</span>
          <span><i class="fas fa-tint" style="color:var(--danger);width:16px;"></i> {{ $medicalRecord->patient->blood_type ?? 'Unknown blood type' }}</span>
          <span><i class="fas fa-birthday-cake" style="color:var(--warning);width:16px;"></i> Age {{ $medicalRecord->patient->age }}</span>
        </div>
        <a href="{{ route('patients.show', $medicalRecord->patient) }}" class="btn btn-outline btn-sm w-full mt-3" style="justify-content:center;">View Full Profile</a>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3 class="card-title">Doctor</h3></div>
      <div class="card-body">
        <div class="flex items-center gap-3">
          <div class="avatar" style="background:linear-gradient(135deg,var(--success),#34d399);">{{ strtoupper(substr($medicalRecord->doctor->user->name ?? 'D',0,2)) }}</div>
          <div>
            <div style="font-weight:700;">Dr. {{ $medicalRecord->doctor->user->name ?? '—' }}</div>
            <div style="font-size:12px;color:var(--gray-400);">{{ $medicalRecord->doctor->specialization }}</div>
          </div>
        </div>
      </div>
    </div>

    @if($medicalRecord->patient->allergies)
    <div class="card" style="border:1px solid var(--danger);background:var(--danger-soft);">
      <div class="card-body">
        <div style="font-weight:700;color:var(--danger);margin-bottom:6px;"><i class="fas fa-exclamation-triangle"></i> Allergies</div>
        <p style="font-size:13px;color:var(--danger);">{{ $medicalRecord->patient->allergies }}</p>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
