<?php

namespace App\Http\Controllers;

use App\Models\{Patient, AuditLog};
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('patient_id', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) $query->where('status', $request->status);
        if ($request->gender) $query->where('gender', $request->gender);
        if ($request->blood_type) $query->where('blood_type', $request->blood_type);

        $patients = $query->latest()->paginate(15)->withQueryString();
        return view('patients.index', compact('patients'));
    }

    public function create() { return view('patients.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'              => 'required|string|max:100',
            'last_name'               => 'required|string|max:100',
            'email'                   => 'nullable|email|unique:patients',
            'phone'                   => 'required|string',
            'date_of_birth'           => 'required|date|before:today',
            'gender'                  => 'required|in:male,female,other',
            'address'                 => 'nullable|string',
            'blood_type'              => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies'               => 'nullable|string',
            'emergency_contact_name'  => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('patients/photos', 'public');
        }

        $patient = Patient::create($data);
        AuditLog::record('Patient Created', $patient, [], $data);

        return redirect()->route('patients.show', $patient)
            ->with('success', "Patient {$patient->full_name} created successfully.");
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'appointments.doctor.user',
            'medicalRecords.doctor.user',
            'prescriptions.doctor.user',
            'labTests.doctor.user',
            'invoices',
        ]);
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient) { return view('patients.edit', compact('patient')); }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'first_name'              => 'required|string|max:100',
            'last_name'               => 'required|string|max:100',
            'email'                   => 'nullable|email|unique:patients,email,' . $patient->id,
            'phone'                   => 'required|string',
            'date_of_birth'           => 'required|date|before:today',
            'gender'                  => 'required|in:male,female,other',
            'address'                 => 'nullable|string',
            'blood_type'              => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies'               => 'nullable|string',
            'emergency_contact_name'  => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'status'                  => 'required|in:active,inactive,deceased',
        ]);

        $old = $patient->toArray();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('patients/photos', 'public');
        }

        $patient->update($data);
        AuditLog::record('Patient Updated', $patient, $old, $data);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        AuditLog::record('Patient Deleted', $patient, $patient->toArray(), []);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient removed.');
    }
}
