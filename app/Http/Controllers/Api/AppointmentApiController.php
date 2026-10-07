<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with(['patient', 'doctor.user'])
            ->when($request->patient_id, fn($q) => $q->where('patient_id', $request->patient_id))
            ->when($request->doctor_id,  fn($q) => $q->where('doctor_id',  $request->doctor_id))
            ->when($request->date,       fn($q) => $q->whereDate('appointment_date', $request->date))
            ->paginate(20);

        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'type'             => 'required',
        ]);

        return response()->json(Appointment::create($data), 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment->load('patient', 'doctor.user'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $appointment->update($request->only('status', 'notes'));
        return response()->json($appointment);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(null, 204);
    }
}
