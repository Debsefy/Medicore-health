<?php

namespace App\Http\Controllers;

use App\Models\{Patient, Doctor, Appointment, Invoice, Drug, LabTest, User, AuditLog};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_patients'        => Patient::count(),
            'total_doctors'         => Doctor::count(),
            'appointments_today'    => Appointment::whereDate('appointment_date', today())->count(),
            'total_revenue'         => Invoice::where('status', 'paid')->sum('total'),
            'pending_appointments'  => Appointment::where('status', 'pending')->count(),
            'confirmed_appointments'=> Appointment::where('status', 'confirmed')->count(),
            'pending_invoices'      => Invoice::whereIn('status', ['sent', 'overdue'])->count(),
            'low_stock_drugs'       => Drug::whereColumn('stock_quantity', '<=', 'minimum_stock')->count(),
            'lab_tests_pending'     => LabTest::whereIn('status', ['requested', 'in_progress'])->count(),
            'new_patients_month'    => Patient::whereMonth('created_at', now()->month)->count(),
        ];

        // Chart data: last 6 months appointments
        $monthlyAppointments = Appointment::select(
                DB::raw('MONTH(appointment_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('appointment_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Chart data: last 6 months revenue
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->select(DB::raw('MONTH(paid_at) as month'), DB::raw('SUM(total) as total'))
            ->whereYear('paid_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Recent appointments
        $recentAppointments = Appointment::with(['patient', 'doctor.user'])
            ->latest()
            ->limit(8)
            ->get();

        // Today's appointments
        $todayAppointments = Appointment::with(['patient', 'doctor.user'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();

        // Recent patients
        $recentPatients = Patient::latest()->limit(5)->get();

        // Appointment status chart
        $appointmentStatus = Appointment::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Audit logs
        $recentLogs = AuditLog::with('user')->latest()->limit(10)->get();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date('M', mktime(0, 0, 0, $i, 1));
        }

        return view('dashboard.admin', compact(
            'stats', 'recentAppointments', 'todayAppointments', 'recentPatients',
            'monthlyAppointments', 'monthlyRevenue', 'appointmentStatus',
            'months', 'recentLogs'
        ));
    }
}
