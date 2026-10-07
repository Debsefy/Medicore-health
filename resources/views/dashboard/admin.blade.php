@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Stats Grid -->
<div class="stat-cards">
  <div class="stat-card blue animate-fade-in">
    <div class="stat-card-top">
      <div class="stat-card-icon"><i class="fas fa-user-injured"></i></div>
      <span class="stat-card-change up"><i class="fas fa-arrow-up"></i> {{ $stats['new_patients_month'] }} this month</span>
    </div>
    <div class="stat-card-value">{{ number_format($stats['total_patients']) }}</div>
    <div class="stat-card-label">Total Patients</div>
  </div>

  <div class="stat-card green animate-fade-in" style="animation-delay:.05s">
    <div class="stat-card-top">
      <div class="stat-card-icon"><i class="fas fa-user-md"></i></div>
      <span class="stat-card-change neutral">Active</span>
    </div>
    <div class="stat-card-value">{{ number_format($stats['total_doctors']) }}</div>
    <div class="stat-card-label">Total Doctors</div>
  </div>

  <div class="stat-card amber animate-fade-in" style="animation-delay:.1s">
    <div class="stat-card-top">
      <div class="stat-card-icon"><i class="fas fa-calendar-check"></i></div>
      <span class="stat-card-change {{ $stats['appointments_today'] > 0 ? 'up' : 'neutral' }}">Today</span>
    </div>
    <div class="stat-card-value">{{ number_format($stats['appointments_today']) }}</div>
    <div class="stat-card-label">Appointments Today</div>
  </div>

  <div class="stat-card red animate-fade-in" style="animation-delay:.15s">
    <div class="stat-card-top">
      <div class="stat-card-icon"><i class="fas fa-naira-sign"></i></div>
      <span class="stat-card-change up">Collected</span>
    </div>
    <div class="stat-card-value">₦{{ number_format($stats['total_revenue'], 0) }}</div>
    <div class="stat-card-label">Total Revenue</div>
  </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-4 mb-6">
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:42px;height:42px;background:var(--warning-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--warning);font-size:18px;"><i class="fas fa-clock"></i></div>
      <div>
        <div style="font-size:22px;font-weight:800;color:var(--gray-900)">{{ $stats['pending_appointments'] }}</div>
        <div style="font-size:12px;color:var(--gray-500)">Pending Appointments</div>
      </div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:42px;height:42px;background:var(--danger-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--danger);font-size:18px;"><i class="fas fa-file-invoice-dollar"></i></div>
      <div>
        <div style="font-size:22px;font-weight:800;color:var(--gray-900)">{{ $stats['pending_invoices'] }}</div>
        <div style="font-size:12px;color:var(--gray-500)">Unpaid Invoices</div>
      </div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:42px;height:42px;background:var(--accent-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--accent);font-size:18px;"><i class="fas fa-pills"></i></div>
      <div>
        <div style="font-size:22px;font-weight:800;color:var(--gray-900)">{{ $stats['low_stock_drugs'] }}</div>
        <div style="font-size:12px;color:var(--gray-500)">Low Stock Drugs</div>
      </div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:42px;height:42px;background:var(--info-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--info);font-size:18px;"><i class="fas fa-flask"></i></div>
      <div>
        <div style="font-size:22px;font-weight:800;color:var(--gray-900)">{{ $stats['lab_tests_pending'] }}</div>
        <div style="font-size:12px;color:var(--gray-500)">Lab Tests Pending</div>
      </div>
    </div>
  </div>
</div>

<!-- Charts Row -->
<div class="grid grid-12 mb-6">
  <div class="card col-8">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-chart-bar" style="color:var(--primary);margin-right:8px;"></i>Monthly Appointments</h3>
      <span style="font-size:12px;color:var(--gray-400);">{{ date('Y') }}</span>
    </div>
    <div class="card-body">
      <div class="chart-wrapper" style="height:260px;">
        <canvas id="appointmentsChart"></canvas>
      </div>
    </div>
  </div>

  <div class="card col-4">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-chart-pie" style="color:var(--success);margin-right:8px;"></i>Appointment Status</h3>
    </div>
    <div class="card-body">
      <div class="chart-wrapper" style="height:260px;">
        <canvas id="statusChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Revenue Chart + Today's Appointments -->
<div class="grid grid-12 mb-6">
  <div class="card col-7">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-chart-line" style="color:var(--success);margin-right:8px;"></i>Revenue Overview</h3>
      <span style="font-size:12px;color:var(--gray-400);">{{ date('Y') }}</span>
    </div>
    <div class="card-body">
      <div class="chart-wrapper" style="height:220px;">
        <canvas id="revenueChart"></canvas>
      </div>
    </div>
  </div>

  <div class="card col-5">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-calendar-day" style="color:var(--warning);margin-right:8px;"></i>Today's Schedule</h3>
      <a href="{{ route('appointments.calendar') }}" class="btn btn-outline btn-sm">Calendar</a>
    </div>
    <div style="max-height:280px;overflow-y:auto;">
      @forelse($todayAppointments as $apt)
      <div style="padding:12px 20px;border-bottom:1px solid var(--gray-100);display:flex;gap:12px;align-items:center;">
        <div style="width:50px;text-align:center;flex-shrink:0;">
          <div style="font-size:13px;font-weight:800;color:var(--gray-800)">{{ date('h:i', strtotime($apt->appointment_time)) }}</div>
          <div style="font-size:10px;color:var(--gray-400)">{{ date('A', strtotime($apt->appointment_time)) }}</div>
        </div>
        <div style="flex:1;min-width:0;">
          <div style="font-size:13px;font-weight:600;color:var(--gray-800);truncate">{{ $apt->patient->full_name }}</div>
          <div style="font-size:12px;color:var(--gray-500)">Dr. {{ $apt->doctor->user->name ?? '—' }}</div>
        </div>
        <span class="badge badge-{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
      </div>
      @empty
      <div class="empty-state" style="padding:30px;">
        <div class="empty-state-icon"><i class="fas fa-calendar-check"></i></div>
        <p>No appointments today</p>
      </div>
      @endforelse
    </div>
  </div>
</div>

<!-- Recent Appointments Table + Recent Patients -->
<div class="grid grid-12">
  <div class="card col-8">
    <div class="card-header">
      <h3 class="card-title">Recent Appointments</h3>
      <a href="{{ route('appointments.index') }}" class="btn btn-outline btn-sm">View All</a>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
      <table class="table">
        <thead>
          <tr>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date & Time</th>
            <th>Type</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentAppointments as $apt)
          <tr>
            <td>
              <div class="flex items-center gap-2">
                <div class="avatar avatar-sm">{{ strtoupper(substr($apt->patient->first_name,0,2)) }}</div>
                <div>
                  <div style="font-weight:600;font-size:13px;">{{ $apt->patient->full_name }}</div>
                  <div style="font-size:11px;color:var(--gray-400)">{{ $apt->patient->patient_id }}</div>
                </div>
              </div>
            </td>
            <td style="font-size:13px;">Dr. {{ $apt->doctor->user->name ?? '—' }}</td>
            <td>
              <div style="font-size:13px;font-weight:500;">{{ $apt->appointment_date->format('M d, Y') }}</div>
              <div style="font-size:11px;color:var(--gray-400)">{{ date('h:i A', strtotime($apt->appointment_time)) }}</div>
            </td>
            <td><span style="font-size:12px;text-transform:capitalize;">{{ str_replace('_',' ',$apt->type) }}</span></td>
            <td><span class="badge badge-{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span></td>
          </tr>
          @empty
          <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--gray-400);">No appointments yet</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card col-4">
    <div class="card-header">
      <h3 class="card-title">Recent Patients</h3>
      <a href="{{ route('patients.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add</a>
    </div>
    <div>
      @forelse($recentPatients as $patient)
      <a href="{{ route('patients.show', $patient) }}" style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid var(--gray-100);text-decoration:none;transition:background .2s;">
        <div class="avatar avatar-sm" style="background:linear-gradient(135deg,{{ ['#0f6fff','#10b981','#f59e0b','#ef4444','#6366f1'][($patient->id % 5)] }},{{ ['#06b6d4','#34d399','#fbbf24','#f87171','#818cf8'][($patient->id % 5)] }})">
          {{ strtoupper(substr($patient->first_name,0,2)) }}
        </div>
        <div style="flex:1;min-width:0;">
          <div style="font-size:13px;font-weight:600;color:var(--gray-800);">{{ $patient->full_name }}</div>
          <div style="font-size:11px;color:var(--gray-400);">{{ $patient->patient_id }} · {{ $patient->phone }}</div>
        </div>
        <span class="badge badge-{{ $patient->status_color }}">{{ ucfirst($patient->status) }}</span>
      </a>
      @empty
      <div class="empty-state" style="padding:30px;">
        <p>No patients yet</p>
      </div>
      @endforelse
    </div>
    <div class="card-footer" style="text-align:center;">
      <a href="{{ route('patients.index') }}" style="font-size:13px;color:var(--primary);font-weight:600;">View all patients →</a>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  initCharts(
    @json($monthlyAppointments),
    @json($monthlyRevenue),
    @json($appointmentStatus),
    @json($months)
  );
</script>
@endpush
