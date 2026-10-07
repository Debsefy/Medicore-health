<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account — MediCore HMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital@0;1&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="auth-wrapper">
  <div class="auth-side">
    <div class="auth-side-content">
      <div class="auth-side-logo"><i class="fas fa-hospital-user"></i></div>
      <h1>Join<br><em>MediCore</em></h1>
      <p>Create your account to start managing your hospital operations efficiently.</p>
      <div class="auth-features">
        <div class="auth-feature"><i class="fas fa-user-shield"></i><span>Secure role-based access</span></div>
        <div class="auth-feature"><i class="fas fa-clock"></i><span>24/7 system availability</span></div>
        <div class="auth-feature"><i class="fas fa-database"></i><span>Complete data management</span></div>
      </div>
    </div>
  </div>

  <div class="auth-form-side">
    <div class="auth-form-box" style="max-width:500px">
      <div class="auth-logo">
        <div class="auth-logo-icon"><i class="fas fa-heartbeat"></i></div>
        <div>
          <div style="font-weight:800;font-size:20px;">MediCore</div>
          <div style="font-size:11px;color:var(--gray-400);text-transform:uppercase;letter-spacing:1px">Hospital Management</div>
        </div>
      </div>

      <h2>Create Account</h2>
      <p class="auth-subtitle">Fill in your details to get started</p>

      @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>
          <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div class="form-row cols-2">
          <div class="form-group">
            <label class="form-label">Full Name <span>*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Dr. Jane Doe" value="{{ old('name') }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number <span>*</span></label>
            <input type="text" name="phone" class="form-control" placeholder="+234 800 000 0000" value="{{ old('phone') }}" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Email Address <span>*</span></label>
          <input type="email" name="email" class="form-control" placeholder="your@hospital.com" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
          <label class="form-label">Role <span>*</span></label>
          <select name="role" class="form-select" required>
            <option value="">— Select your role —</option>
            <option value="admin"         {{ old('role')=='admin'         ? 'selected' : '' }}>Administrator</option>
            <option value="doctor"        {{ old('role')=='doctor'        ? 'selected' : '' }}>Doctor</option>
            <option value="nurse"         {{ old('role')=='nurse'         ? 'selected' : '' }}>Nurse</option>
            <option value="receptionist"  {{ old('role')=='receptionist'  ? 'selected' : '' }}>Receptionist</option>
          </select>
        </div>

        <div class="form-row cols-2">
          <div class="form-group">
            <label class="form-label">Password <span>*</span></label>
            <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
          </div>
          <div class="form-group">
            <label class="form-label">Confirm Password <span>*</span></label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-full btn-lg">
          <i class="fas fa-user-plus"></i> Create Account
        </button>
      </form>

      <p class="auth-footer-text">Already have an account? <a href="{{ route('login') }}" style="font-weight:600;">Sign in</a></p>
    </div>
  </div>
</div>
</body>
</html>
