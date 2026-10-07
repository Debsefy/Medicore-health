<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In — MediCore HMS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="auth-wrapper">

  <!-- Left Side -->
  <div class="auth-side">
    <div class="auth-side-content">
      <div class="auth-side-logo"><i class="fas fa-heartbeat"></i></div>
      <h1>MediCore<br><em>HMS</em></h1>
      <p>The complete hospital management platform built for modern healthcare facilities.</p>

      <div class="auth-features">
        <div class="auth-feature">
          <i class="fas fa-shield-alt"></i>
          <span>Role-based access control for all staff</span>
        </div>
        <div class="auth-feature">
          <i class="fas fa-chart-line"></i>
          <span>Real-time analytics & reporting dashboard</span>
        </div>
        <div class="auth-feature">
          <i class="fas fa-mobile-alt"></i>
          <span>Mobile-ready with full REST API</span>
        </div>
        <div class="auth-feature">
          <i class="fas fa-lock"></i>
          <span>HIPAA-compliant audit logging</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Side: Form -->
  <div class="auth-form-side">
    <div class="auth-form-box">

      <div class="auth-logo">
        <div class="auth-logo-icon"><i class="fas fa-heartbeat"></i></div>
        <div>
          <div style="font-weight:800;font-size:20px;color:var(--gray-900)">MediCore</div>
          <div style="font-size:11px;color:var(--gray-400);text-transform:uppercase;letter-spacing:1px">Hospital Management</div>
        </div>
      </div>

      <h2>Welcome back</h2>
      <p class="auth-subtitle">Sign in to access your dashboard</p>

      @if($errors->any())
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle"></i>
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="form-group">
          <label class="form-label">Email Address <span>*</span></label>
          <div style="position:relative;">
            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--gray-400);"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control" style="padding-left:38px;" placeholder="doctor@hospital.com" value="{{ old('email') }}" required autofocus>
          </div>
        </div>

        <div class="form-group">
          <div class="flex justify-between items-center mb-2">
            <label class="form-label" style="margin:0">Password <span>*</span></label>
            <a href="#" style="font-size:12px;color:var(--primary);">Forgot password?</a>
          </div>
          <div style="position:relative;">
            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--gray-400);"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" id="passwordField" class="form-control" style="padding-left:38px;padding-right:42px;" placeholder="Your password" required>
            <button type="button" onclick="togglePwd()" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);">
              <i class="fas fa-eye" id="pwdIcon"></i>
            </button>
          </div>
        </div>

        <div class="flex items-center gap-2 mb-4">
          <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;accent-color:var(--primary);">
          <label for="remember" style="font-size:13px;color:var(--gray-600);">Remember me for 30 days</label>
        </div>

        <button type="submit" class="btn btn-primary w-full btn-lg">
          <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
      </form>

      <div class="auth-divider"><span>OR</span></div>

      <p class="auth-footer-text">
        Don't have an account? <a href="{{ route('register') }}" style="font-weight:600;">Create account</a>
      </p>

      <!-- Demo Credentials -->
      <div style="margin-top:24px;background:var(--gray-100);border-radius:var(--border-radius-sm);padding:14px 16px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-500);margin-bottom:10px;">
          <i class="fas fa-info-circle"></i> Demo Credentials
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
          @foreach([['Admin','admin@hospital.com'],['Doctor','doctor@hospital.com'],['Nurse','nurse@hospital.com'],['Reception','reception@hospital.com']] as $demo)
          <button onclick="fillDemo('{{ $demo[1] }}')" style="background:var(--white);border:1px solid var(--gray-200);border-radius:6px;padding:7px 10px;cursor:pointer;font-size:12px;font-weight:600;color:var(--gray-700);transition:all .2s;">
            <i class="fas fa-user" style="color:var(--primary);margin-right:4px;"></i>{{ $demo[0] }}
          </button>
          @endforeach
        </div>
        <div style="font-size:11px;color:var(--gray-400);margin-top:8px;text-align:center;">Password: <strong>password</strong></div>
      </div>

    </div>
  </div>
</div>

<script>
function togglePwd() {
  const f = document.getElementById('passwordField');
  const i = document.getElementById('pwdIcon');
  if (f.type === 'password') { f.type = 'text'; i.className = 'fas fa-eye-slash'; }
  else { f.type = 'password'; i.className = 'fas fa-eye'; }
}
function fillDemo(email) {
  document.querySelector('[name=email]').value = email;
  document.getElementById('passwordField').value = 'password';
}
</script>
</body>
</html>
