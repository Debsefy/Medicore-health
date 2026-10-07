<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — MediCore HMS</title>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- App CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  @stack('styles')
</head>
<body>

<div class="app-wrapper">

  <!-- ── SIDEBAR ───────────────────────────────────────── -->
  <aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">
      <div class="sidebar-brand-icon"><i class="fas fa-heartbeat"></i></div>
      <div class="sidebar-brand-text">
        <div class="brand-name">MediCore</div>
        <div class="brand-tagline">Hospital Management</div>
      </div>
    </div>

    <div class="sidebar-user">
      <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
      <div class="sidebar-user-info">
        <div class="user-name">{{ auth()->user()->name }}</div>
        <div class="user-role">{{ auth()->user()->role }}</div>
      </div>
    </div>

    <nav class="sidebar-nav">

      <div class="nav-section-title">Overview</div>

      <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-th-large"></i></span> Dashboard
      </a>

      <div class="nav-section-title">Clinical</div>

      <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-user-injured"></i></span> Patients
      </a>

      <a href="{{ route('appointments.index') }}" class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-calendar-check"></i></span> Appointments
        @php $pendingApts = \App\Models\Appointment::where('status','pending')->count(); @endphp
        @if($pendingApts > 0)<span class="nav-badge">{{ $pendingApts }}</span>@endif
      </a>

      <a href="{{ route('appointments.calendar') }}" class="nav-link {{ request()->routeIs('appointments.calendar') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span> Calendar
      </a>

      <a href="{{ route('medical-records.index') }}" class="nav-link {{ request()->routeIs('medical-records.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-file-medical"></i></span> Medical Records
      </a>

      <div class="nav-section-title">Services</div>

      <a href="{{ route('pharmacy.index') }}" class="nav-link {{ request()->routeIs('pharmacy.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-pills"></i></span> Pharmacy
        @php $lowStock = \App\Models\Drug::whereColumn('stock_quantity','<=','minimum_stock')->count(); @endphp
        @if($lowStock > 0)<span class="nav-badge">{{ $lowStock }}</span>@endif
      </a>

      <a href="{{ route('lab.index') }}" class="nav-link {{ request()->routeIs('lab.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-flask"></i></span> Laboratory
      </a>

      <a href="{{ route('billing.index') }}" class="nav-link {{ request()->routeIs('billing.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-file-invoice-dollar"></i></span> Billing
      </a>

      @if(auth()->user()->isAdmin() || auth()->user()->isDoctor())
      <div class="nav-section-title">Administration</div>

      @if(auth()->user()->isAdmin())
      <a href="{{ route('doctors.index') }}" class="nav-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-user-md"></i></span> Doctors
      </a>

      <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-users-cog"></i></span> Users
      </a>

      <a href="{{ route('audit-logs.index') }}" class="nav-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-history"></i></span> Audit Logs
      </a>
      @endif
      @endif

    </nav>

    <div class="sidebar-footer">
      <a href="{{ route('notifications.index') }}" class="nav-link">
        <span class="nav-icon"><i class="fas fa-bell"></i></span> Notifications
        @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
        @if($unread > 0)<span class="nav-badge">{{ $unread }}</span>@endif
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-link w-full" style="border:none;background:none;cursor:pointer;text-align:left;">
          <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span> Sign Out
        </button>
      </form>
    </div>
  </aside>

  <!-- ── OVERLAY (mobile) ─────────────────────────────── -->
  <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:99;" onclick="document.getElementById('sidebar').classList.remove('open');this.style.display='none';"></div>

  <!-- ── MAIN CONTENT ─────────────────────────────────── -->
  <div class="main-content">

    <!-- Topbar -->
    <header class="topbar">
      <button id="sidebarToggle" class="topbar-btn" style="display:none;">
        <i class="fas fa-bars"></i>
      </button>

      <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>

      <form action="{{ request()->url() }}" method="GET" class="topbar-search">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Quick search..." value="{{ request('search') }}">
      </form>

      <div class="topbar-actions">
        <button id="darkModeToggle" class="topbar-btn" title="Toggle dark mode">
          <i class="fas fa-moon"></i>
        </button>

        <a href="{{ route('notifications.index') }}" class="topbar-btn" title="Notifications">
          <i class="fas fa-bell"></i>
          @if(auth()->user()->unreadNotifications()->count() > 0)
            <span class="badge-dot"></span>
          @endif
        </a>

        <div class="dropdown">
          <div class="topbar-avatar dropdown-toggle" title="{{ auth()->user()->name }}">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          </div>
          <div class="dropdown-menu">
            <div style="padding:12px 16px;border-bottom:1px solid var(--gray-100)">
              <div style="font-weight:700;font-size:14px;">{{ auth()->user()->name }}</div>
              <div style="font-size:12px;color:var(--gray-500);">{{ auth()->user()->email }}</div>
              <div class="mt-1">
                <span class="badge badge-{{ auth()->user()->role_color }}">{{ ucfirst(auth()->user()->role) }}</span>
              </div>
            </div>
            <a href="#" class="dropdown-item"><i class="fas fa-user"></i> My Profile</a>
            <a href="#" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item" style="width:100%;border:none;background:none;cursor:pointer;color:var(--danger);">
                <i class="fas fa-sign-out-alt"></i> Sign Out
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <!-- Flash Messages -->
    <div style="padding: 0 24px;">
      @if(session('success'))
        <div class="alert alert-success" data-dismiss="true" style="margin-top:16px;">
          <i class="fas fa-check-circle"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger" data-dismiss="true" style="margin-top:16px;">
          <i class="fas fa-exclamation-circle"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger" style="margin-top:16px;">
          <i class="fas fa-exclamation-circle"></i>
          <div>
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    <!-- Page Content -->
    <main class="page-content">
      @yield('content')
    </main>

  </div><!-- end main-content -->

</div><!-- end app-wrapper -->

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>
  // Mobile sidebar toggle show
  if (window.innerWidth <= 991) {
    document.getElementById('sidebarToggle').style.display = 'flex';
  }
  window.addEventListener('resize', () => {
    const toggle = document.getElementById('sidebarToggle');
    if (toggle) toggle.style.display = window.innerWidth <= 991 ? 'flex' : 'none';
  });
</script>

@stack('scripts')
</body>
</html>
