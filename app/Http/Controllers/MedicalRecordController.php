<?php

namespace App\Http\Controllers;

use App\Models\{MedicalRecord, Prescription, Patient, Doctor, Appointment, AuditLog};
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient','doctor.user']);
        if ($request->search) {
            $query->whereHas('patient', fn($q) => $q->where('first_name','like',"%{$request->search}%")->orWhere('last_name','like',"%{$request->search}%"));
        }
        if ($request->doctor_id) $query->where('doctor_id', $request->doctor_id);
        $records  = $query->latest('visit_date')->paginate(15)->withQueryString();
        $doctors  = Doctor::with('user')->get();
        return view('medical-records.index', compact('records','doctors'));
    }

    public function create(Request $request)
    {
        $patients     = Patient::where('status','active')->get();
        $doctors      = Doctor::with('user')->get();
        $appointments = $request->appointment_id
            ? Appointment::where('id',$request->appointment_id)->get()
            : collect();
        $selectedPatient = $request->patient_id ? Patient::find($request->patient_id) : null;
        return view('medical-records.create', compact('patients','doctors','appointments','selectedPatient'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'doctor_id'      => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'visit_date'     => 'required|date',
            'chief_complaint'=> 'required|string',
            'diagnosis'      => 'required|string',
            'treatment_plan' => 'nullable|string',
            'notes'          => 'nullable|string',
            'weight'         => 'nullable|numeric',
            'height'         => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'temperature'    => 'nullable|numeric',
            'pulse_rate'     => 'nullable|integer',
        ]);

        $record = MedicalRecord::create($data);

        // Handle prescriptions if provided
        if ($request->has('medications') && count(array_filter($request->medications ?? []))) {
            Prescription::create([
                'medical_record_id' => $record->id,
                'patient_id'        => $record->patient_id,
                'doctor_id'         => $record->doctor_id,
                'medications'       => $request->medications,
                'notes'             => $request->prescription_notes,
            ]);
        }

        // Update appointment status
        if ($data['appointment_id']) {
            Appointment::find($data['appointment_id'])->update(['status' => 'completed']);
        }

        AuditLog::record('Medical Record Created', $record);
        return redirect()->route('medical-records.show', $record)->with('success', 'Medical record saved.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient','doctor.user','prescriptions','labTests']);
        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $doctors = Doctor::with('user')->get();
        return view('medical-records.edit', compact('medicalRecord','doctors'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $data = $request->validate([
            'chief_complaint'=> 'required|string',
            'diagnosis'      => 'required|string',
            'treatment_plan' => 'nullable|string',
            'notes'          => 'nullable|string',
            'weight'         => 'nullable|numeric',
            'height'         => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'temperature'    => 'nullable|numeric',
            'pulse_rate'     => 'nullable|integer',
        ]);

        $medicalRecord->update($data);
        AuditLog::record('Medical Record Updated', $medicalRecord);
        return redirect()->route('medical-records.show', $medicalRecord)->with('success', 'Record updated.');
    }
}
