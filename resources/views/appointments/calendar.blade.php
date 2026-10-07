@extends('layouts.app')
@section('title','Calendar')
@section('page-title','Appointment Calendar')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
<style>
.fc-toolbar h2 { font-size:18px; font-weight:800; color:var(--gray-900); }
.fc-button { background:var(--primary)!important; border-color:var(--primary)!important; font-size:13px!important; border-radius:6px!important; }
.fc-button:hover { background:var(--primary-dark)!important; }
.fc-today { background:var(--primary-light)!important; }
.fc-event { border-radius:6px!important; border:none!important; font-size:12px!important; padding:2px 6px!important; }
.fc-day-header { font-weight:700; font-size:12px; color:var(--gray-500); text-transform:uppercase; letter-spacing:.5px; }
</style>
@endpush

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('appointments.index') }}">Appointments</a><span>/</span><span>Calendar</span></div>
    <h1 class="page-title">Appointment Calendar</h1>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('appointments.index') }}" class="btn btn-outline"><i class="fas fa-list"></i> List View</a>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Book Appointment</a>
  </div>
</div>

<div class="grid grid-12">
  <div class="card col-9">
    <div class="card-body">
      <div id="calendar"></div>
    </div>
  </div>

  <div class="col-3" style="display:flex;flex-direction:column;gap:16px;">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Legend</h3></div>
      <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
        @foreach(['pending'=>['#f59e0b','Pending'],'confirmed'=>['#2563eb','Confirmed'],'completed'=>['#16a34a','Completed'],'cancelled'=>['#dc2626','Cancelled'],'no_show'=>['#6b7280','No Show']] as $status=>[$color,$label])
        <div class="flex items-center gap-2">
          <span style="width:14px;height:14px;border-radius:4px;background:{{ $color }};flex-shrink:0;"></span>
          <span style="font-size:13px;color:var(--gray-600);">{{ $label }}</span>
        </div>
        @endforeach
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3 class="card-title">Today's Summary</h3></div>
      <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
        @php
          $todayCounts = collect($appointments)->filter(fn($a) => str_starts_with($a['start'] ?? '', date('Y-m-d')));
        @endphp
        <div style="font-size:26px;font-weight:800;color:var(--primary);text-align:center;">{{ $todayCounts->count() }}</div>
        <div style="font-size:13px;color:var(--gray-500);text-align:center;">appointments today</div>
        <a href="{{ route('appointments.index') }}?date={{ date('Y-m-d') }}" class="btn btn-outline btn-sm" style="justify-content:center;">View Today's List</a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script>
$(document).ready(function() {
  $('#calendar').fullCalendar({
    header: { left:'prev,next today', center:'title', right:'month,agendaWeek,agendaDay' },
    defaultView: 'month',
    editable: false,
    eventLimit: true,
    events: @json(array_values($appointments)),
    eventClick: function(event) { if(event.url){ window.location = event.url; return false; } },
    height: 'auto',
    businessHours: { dow:[1,2,3,4,5], start:'08:00', end:'18:00' }
  });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush
