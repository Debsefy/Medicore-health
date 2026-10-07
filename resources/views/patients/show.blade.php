@extends('layouts.app')
@section('title', $patient->full_name)
@section('page-title', 'Patient Profile')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('patients.index') }}">Patients</a><span>/</span><span>{{ $patient->full_name }}</span></div>
    <h1 class="page-title">{{ $patient->full_name }}</h1>
    <p class="page-subtitle">{{ $patient->patient_id }}</p>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('appointments.create') }}?patient_id={{ $patient->id }}" class="btn btn-outline"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
    <a href="{{ route('medical-records.create') }}?patient_id={{ $patient->id }}" class="btn btn-outline"><i class="fas fa-file-medical"></i> Add Record</a>
    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
  </div>
</div>

<div class="grid grid-12">

  <!-- Profile Card -->
  <div class="col-4" style="display:flex;flex-direction:column;gap:18px;">

    <div class="card">
      <div class="profile-card-banner"></div>
      <div class="profile-card-body">
        <div class="profile-card-avatar">
          @if($patient->photo)
            <img src="{{ asset('storage/'.$patient->photo) }}" style="width:64px;height:64px;border-radius:50%;border:3px solid var(--white);box-shadow:var(--shadow-sm);object-fit:cover;">
          @else
            <div class="avatar" style="width:64px;height:64px;font-size:22px;border:3px solid var(--white);box-shadow:var(--shadow-sm);">{{ strtoupper(substr($patient->first_name,0,2)) }}</div>
          @endif
        </div>
        <div style="margin-bottom:12px;">
          <h2 style="font-size:20px;font-weight:800;color:var(--gray-900);">{{ $patient->full_name }}</h2>
          <div style="font-size:13px;color:var(--gray-500);">{{ $patient->patient_id }}</div>
          <div class="mt-2 flex gap-2 flex-wrap">
            <span class="badge badge-{{ $patient->status_color }}">{{ ucfirst($patient->status) }}</span>
            @if($patient->blood_type)
              <span style="background:var(--danger-soft);color:var(--danger);padding:3px 8px;border-radius:20px;font-size:11px;font-weight:700;">{{ $patient->blood_type }}</span>
            @endif
            <span class="badge badge-secondary">{{ ucfirst($patient->gender) }}</span>
          </div>
        </div>

        <div style="display:grid;gap:10px;">
          <div class="flex items-center gap-2"><i class="fas fa-birthday-cake" style="color:var(--primary);width:16px;text-align:center;font-size:13px;"></i><span style="font-size:13px;">{{ $patient->date_of_birth->format('M d, Y') }} (Age {{ $patient->age }})</span></div>
          <div class="flex items-center gap-2"><i class="fas fa-phone" style="color:var(--success);width:16px;text-align:center;font-size:13px;"></i><span style="font-size:13px;">{{ $patient->phone }}</span></div>
          @if($patient->email)<div class="flex items-center gap-2"><i class="fas fa-envelope" style="color:var(--warning);width:16px;text-align:center;font-size:13px;"></i><span style="font-size:13px;">{{ $patient->email }}</span></div>@endif
          @if($patient->address)<div class="flex items-center gap-2"><i class="fas fa-map-marker-alt" style="color:var(--danger);width:16px;text-align:center;font-size:13px;"></i><span style="font-size:13px;">{{ $patient->address }}</span></div>@endif
        </div>
      </div>
    </div>

    @if($patient->allergies)
    <div class="card" style="border-left:4px solid var(--danger);">
      <div class="card-body">
        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--danger);margin-bottom:8px;"><i class="fas fa-exclamation-triangle"></i> Allergies</div>
        <p style="font-size:13px;color:var(--gray-700);">{{ $patient->allergies }}</p>
      </div>
    </div>
    @endif

    @if($patient->emergency_contact_name)
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-phone-alt" style="color:var(--danger);margin-right:6px;"></i>Emergency Contact</h3></div>
      <div class="card-body">
        <p style="font-weight:600;">{{ $patient->emergency_contact_name }}</p>
        <p style="font-size:13px;color:var(--gray-500);">{{ $patient->emergency_contact_phone }}</p>
      </div>
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="card">
      <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;text-align:center;">
          <div><div style="font-size:24px;font-weight:800;color:var(--primary);">{{ $patient->appointments->count() }}</div><div style="font-size:12px;color:var(--gray-500);">Appointments</div></div>
          <div><div style="font-size:24px;font-weight:800;color:var(--success);">{{ $patient->medicalRecords->count() }}</div><div style="font-size:12px;color:var(--gray-500);">Visits</div></div>
          <div><div style="font-size:24px;font-weight:800;color:var(--warning);">{{ $patient->prescriptions->count() }}</div><div style="font-size:12px;color:var(--gray-500);">Prescriptions</div></div>
          <div><div style="font-size:24px;font-weight:800;color:var(--info);">{{ $patient->labTests->count() }}</div><div style="font-size:12px;color:var(--gray-500);">Lab Tests</div></div>
        </div>
      </div>
    </div>

  </div>

  <!-- Tabs Content -->
  <div class="col-8">
    <div class="card">
      <div class="card-body" style="padding-bottom:0;">
        <div class="tabs" data-tab-group="patient">
          <button class="tab-btn active" data-tab="appointments" data-tab-group="patient">Appointments</button>
          <button class="tab-btn" data-tab="records" data-tab-group="patient">Medical Records</button>
          <button class="tab-btn" data-tab="prescriptions" data-tab-group="patient">Prescriptions</button>
          <button class="tab-btn" data-tab="lab" data-tab-group="patient">Lab Tests</button>
          <button class="tab-btn" data-tab="invoices" data-tab-group="patient">Billing</button>
        </div>
      </div>

      <!-- Appointments Tab -->
      <div class="tab-panel active" data-tab="appointments" data-tab-group="patient">
        <div class="table-wrapper" style="border:none;border-radius:0;">
          <table class="table">
            <thead><tr><th>Date & Time</th><th>Doctor</th><th>Type</th><th>Status</th><th></th></tr></thead>
            <tbody>
              @forelse($patient->appointments as $apt)
              <tr>
                <td>
                  <div style="font-weight:600;font-size:13px;">{{ $apt->appointment_date->format('M d, Y') }}</div>
                  <div style="font-size:11px;color:var(--gray-400);">{{ date('h:i A', strtotime($apt->appointment_time)) }}</div>
                </td>
                <td style="font-size:13px;">Dr. {{ $apt->doctor->user->name ?? '—' }}</td>
                <td style="font-size:12px;text-transform:capitalize;">{{ str_replace('_',' ',$apt->type) }}</td>
                <td><span class="badge badge-{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span></td>
                <td><a href="{{ route('appointments.show', $apt) }}" class="btn btn-outline btn-icon btn-sm"><i class="fas fa-eye"></i></a></td>
              </tr>
              @empty
              <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--gray-400);">No appointments</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Medical Records Tab -->
      <div class="tab-panel" data-tab="records" data-tab-group="patient">
        <div class="timeline" style="padding:20px 20px 20px 44px;">
          @forelse($patient->medicalRecords as $record)
          <div class="timeline-item">
            <div class="timeline-date">{{ $record->visit_date->format('M d, Y') }} — Dr. {{ $record->doctor->user->name ?? '—' }}</div>
            <div class="timeline-content">
              <div style="font-weight:700;font-size:14px;margin-bottom:4px;">{{ $record->chief_complaint }}</div>
              <div style="font-size:13px;color:var(--gray-600);"><strong>Diagnosis:</strong> {{ $record->diagnosis }}</div>
              @if($record->treatment_plan)<div style="font-size:13px;color:var(--gray-600);margin-top:4px;"><strong>Treatment:</strong> {{ $record->treatment_plan }}</div>@endif
              <div class="flex gap-2 mt-3">
                <a href="{{ route('medical-records.show', $record) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> View</a>
              </div>
            </div>
          </div>
          @empty
          <div style="text-align:center;padding:30px;color:var(--gray-400);">No medical records yet</div>
          @endforelse
        </div>
      </div>

      <!-- Prescriptions Tab -->
      <div class="tab-panel" data-tab="prescriptions" data-tab-group="patient">
        <div class="table-wrapper" style="border:none;border-radius:0;">
          <table class="table">
            <thead><tr><th>Rx Number</th><th>Date</th><th>Doctor</th><th>Medications</th><th>Status</th></tr></thead>
            <tbody>
              @forelse($patient->prescriptions as $rx)
              <tr>
                <td><code style="font-size:12px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $rx->prescription_number }}</code></td>
                <td style="font-size:13px;">{{ $rx->created_at->format('M d, Y') }}</td>
                <td style="font-size:13px;">Dr. {{ $rx->doctor->user->name ?? '—' }}</td>
                <td style="font-size:13px;">{{ count($rx->medications) }} medication(s)</td>
                <td>
                  <span class="badge badge-{{ ['pending'=>'warning','dispensed'=>'success','cancelled'=>'danger'][$rx->status] ?? 'secondary' }}">
                    {{ ucfirst($rx->status) }}
                  </span>
                </td>
              </tr>
              @empty
              <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--gray-400);">No prescriptions</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Lab Tests Tab -->
      <div class="tab-panel" data-tab="lab" data-tab-group="patient">
        <div class="table-wrapper" style="border:none;border-radius:0;">
          <table class="table">
            <thead><tr><th>Test #</th><th>Test Name</th><th>Type</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
              @forelse($patient->labTests as $test)
              <tr>
                <td><code style="font-size:12px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $test->test_number }}</code></td>
                <td style="font-size:13px;font-weight:600;">{{ $test->test_name }}</td>
                <td style="font-size:12px;">{{ $test->test_type }}</td>
                <td><span class="badge badge-{{ $test->status_color }}">{{ ucfirst(str_replace('_',' ',$test->status)) }}</span></td>
                <td style="font-size:13px;">{{ $test->created_at->format('M d, Y') }}</td>
              </tr>
              @empty
              <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--gray-400);">No lab tests</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Invoices Tab -->
      <div class="tab-panel" data-tab="invoices" data-tab-group="patient">
        <div class="table-wrapper" style="border:none;border-radius:0;">
          <table class="table">
            <thead><tr><th>Invoice #</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr></thead>
            <tbody>
              @forelse($patient->invoices as $inv)
              <tr>
                <td><code style="font-size:12px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $inv->invoice_number }}</code></td>
                <td style="font-size:13px;">{{ $inv->created_at->format('M d, Y') }}</td>
                <td style="font-size:14px;font-weight:700;">₦{{ number_format($inv->total, 2) }}</td>
                <td><span class="badge badge-{{ $inv->status_color }}">{{ ucfirst($inv->status) }}</span></td>
                <td><a href="{{ route('billing.show', $inv) }}" class="btn btn-outline btn-sm btn-icon"><i class="fas fa-eye"></i></a></td>
              </tr>
              @empty
              <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--gray-400);">No invoices</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

</div>

@endsection
