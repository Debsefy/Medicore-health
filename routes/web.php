<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\{
    DashboardController, PatientController, DoctorController,
    AppointmentController, MedicalRecordController,
    PharmacyController, LabController, BillingController
};

// Auth
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.submit');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Patients
    Route::resource('patients', PatientController::class);

    // Doctors – admin only
    Route::resource('doctors', DoctorController::class)->middleware('role:admin');

    // Appointments
    Route::get('/appointments/calendar', [AppointmentController::class, 'calendar'])->name('appointments.calendar');
    Route::resource('appointments', AppointmentController::class);

    // Medical Records
    Route::resource('medical-records', MedicalRecordController::class);

    // Pharmacy
    Route::resource('pharmacy', PharmacyController::class);

    // Lab
    Route::get('/lab',               [LabController::class, 'index'])->name('lab.index');
    Route::get('/lab/create',        [LabController::class, 'create'])->name('lab.create');
    Route::post('/lab',              [LabController::class, 'store'])->name('lab.store');
    Route::get('/lab/{lab}',         [LabController::class, 'show'])->name('lab.show');
    Route::put('/lab/{lab}',         [LabController::class, 'update'])->name('lab.update');

    // Billing
    Route::get('/billing/print/{invoice}', [BillingController::class, 'print'])->name('billing.print');
    Route::post('/billing/{invoice}/paid', [BillingController::class, 'markPaid'])->name('billing.markPaid');
    Route::resource('billing', BillingController::class);

    // Notifications
    Route::get('/notifications', fn() => view('notifications.index', [
        'notifications' => auth()->user()->notifications()->latest()->paginate(20)
    ]))->name('notifications.index');
    Route::post('/notifications/{id}/read', function($id) {
        auth()->user()->notifications()->where('id',$id)->update(['is_read' => true]);
        return back();
    })->name('notifications.read');
    Route::post('/notifications/read-all', function() {
        auth()->user()->notifications()->update(['is_read' => true]);
        return back()->with('success', 'All marked as read.');
    })->name('notifications.readAll');

    // Audit Logs
    Route::get('/audit-logs', function() {
        $logs = \App\Models\AuditLog::with('user')->latest()->paginate(30);
        return view('audit-logs.index', compact('logs'));
    })->name('audit-logs.index')->middleware('role:admin');

    // Users Management
    Route::get('/users', function() {
        $users = \App\Models\User::latest()->paginate(20);
        return view('users.index', compact('users'));
    })->name('users.index')->middleware('role:admin');
});
