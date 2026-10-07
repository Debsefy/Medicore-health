<?php

namespace App\Http\Controllers;

use App\Models\{Doctor, User, Appointment, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('user');
        if ($request->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                  ->orWhere('specialization', 'like', "%{$request->search}%")
                  ->orWhere('doctor_id', 'like', "%{$request->search}%");
        }
        if ($request->specialization) $query->where('specialization', $request->search);
        $doctors = $query->paginate(12)->withQueryString();
        return view('doctors.index', compact('doctors'));
    }

    public function create() { return view('doctors.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string',
            'email'            => 'required|email|unique:users',
            'phone'            => 'required',
            'password'         => 'required|min:8|confirmed',
            'specialization'   => 'required|string',
            'qualification'    => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'available_days'   => 'nullable|array',
            'available_from'   => 'nullable',
            'available_to'     => 'nullable',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'doctor',
        ]);

        $doctor = Doctor::create([
            'user_id'          => $user->id,
            'specialization'   => $request->specialization,
            'qualification'    => $request->qualification,
            'experience_years' => $request->experience_years,
            'license_number'   => $request->license_number,
            'consultation_fee' => $request->consultation_fee,
            'available_days'   => $request->available_days ?? [],
            'available_from'   => $request->available_from,
            'available_to'     => $request->available_to,
            'bio'              => $request->bio,
        ]);

        AuditLog::record('Doctor Created', $doctor);
        return redirect()->route('doctors.show', $doctor)->with('success', 'Doctor added successfully.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('user');
        $appointments = Appointment::where('doctor_id', $doctor->id)->with('patient')->latest()->limit(10)->get();
        $stats = [
            'total_appointments' => Appointment::where('doctor_id', $doctor->id)->count(),
            'completed'          => Appointment::where('doctor_id', $doctor->id)->where('status', 'completed')->count(),
            'today'              => Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', today())->count(),
        ];
        return view('doctors.show', compact('doctor', 'appointments', 'stats'));
    }

    public function edit(Doctor $doctor) { return view('doctors.edit', compact('doctor')); }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'specialization'   => 'required|string',
            'qualification'    => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'available_days'   => 'nullable|array',
            'available_from'   => 'nullable',
            'available_to'     => 'nullable',
            'bio'              => 'nullable|string',
            'is_available'     => 'boolean',
        ]);

        $doctor->update($data);
        $doctor->user->update(['name' => $request->name, 'phone' => $request->phone]);
        AuditLog::record('Doctor Updated', $doctor);
        return redirect()->route('doctors.show', $doctor)->with('success', 'Doctor updated.');
    }

    public function destroy(Doctor $doctor)
    {
        AuditLog::record('Doctor Deleted', $doctor);
        $doctor->user->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor removed.');
    }
}
