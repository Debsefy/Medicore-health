<?php

namespace App\Http\Controllers;

use App\Models\{Appointment, Patient, Doctor, Invoice, InvoiceItem, AuditLog, SystemNotification};
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.user']);

        if ($request->search) {
            $query->whereHas('patient', fn($q) => $q->where('first_name','like',"%{$request->search}%")
                ->orWhere('last_name','like',"%{$request->search}%")
                ->orWhere('patient_id','like',"%{$request->search}%")
            )->orWhere('appointment_number','like',"%{$request->search}%");
        }
        if ($request->status) $query->where('status', $request->status);
        if ($request->date) $query->whereDate('appointment_date', $request->date);
        if ($request->doctor_id) $query->where('doctor_id', $request->doctor_id);

        $appointments = $query->orderBy('appointment_date','desc')->orderBy('appointment_time')->paginate(15)->withQueryString();
        $doctors = Doctor::with('user')->get();
        return view('appointments.index', compact('appointments', 'doctors'));
    }

    public function create()
    {
        $patients = Patient::where('status','active')->get();
        $doctors  = Doctor::with('user')->where('is_available',true)->get();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'type'             => 'required|in:consultation,follow_up,emergency,routine',
            'reason'           => 'nullable|string',
            'notes'            => 'nullable|string',
        ]);

        $data['booked_by'] = auth()->user()->name;
        $appointment = Appointment::create($data);

        // Notify doctor
        $doctor = Doctor::find($data['doctor_id']);
        $patient = Patient::find($data['patient_id']);
        SystemNotification::send(
            $doctor->user_id,
            'New Appointment',
            "Appointment booked with {$patient->full_name} on {$appointment->appointment_date->format('M d, Y')} at " . date('h:i A', strtotime($appointment->appointment_time)),
            'info','fa-calendar-plus',
            route('appointments.show', $appointment)
        );

        AuditLog::record('Appointment Created', $appointment);
        return redirect()->route('appointments.show', $appointment)->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient','doctor.user','medicalRecord.prescriptions','invoice.items']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('status','active')->get();
        $doctors  = Doctor::with('user')->get();
        return view('appointments.edit', compact('appointment','patients','doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'type'             => 'required',
            'status'           => 'required|in:pending,confirmed,completed,cancelled,no_show',
            'notes'            => 'nullable|string',
        ]);

        $old = $appointment->toArray();
        $appointment->update($data);
        AuditLog::record('Appointment Updated', $appointment, $old, $data);

        return redirect()->route('appointments.show', $appointment)->with('success', 'Appointment updated.');
    }

    public function destroy(Appointment $appointment)
    {
        AuditLog::record('Appointment Deleted', $appointment);
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment removed.');
    }

    public function calendar()
    {
        $appointments = Appointment::with(['patient','doctor.user'])
            ->whereBetween('appointment_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->get()
            ->map(fn($a) => [
                'id'    => $a->id,
                'title' => $a->patient->full_name . ' — Dr. ' . $a->doctor->user->name,
                'start' => $a->appointment_date->format('Y-m-d') . 'T' . $a->appointment_time,
                'color' => match($a->status) {
                    'confirmed' => '#2563eb',
                    'completed' => '#16a34a',
                    'cancelled' => '#dc2626',
                    'no_show'   => '#6b7280',
                    default     => '#d97706',
                },
                'url'   => route('appointments.show', $a->id),
            ]);

        return view('appointments.calendar', compact('appointments'));
    }
}
