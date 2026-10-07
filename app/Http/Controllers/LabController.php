<?php

namespace App\Http\Controllers;

use App\Models\{LabTest, Patient, Doctor, MedicalRecord, AuditLog};
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index(Request $request)
    {
        $query = LabTest::with(['patient','doctor.user']);
        if ($request->search) {
            $query->whereHas('patient', fn($q) => $q->where('first_name','like',"%{$request->search}%")->orWhere('last_name','like',"%{$request->search}%"))
                  ->orWhere('test_number','like',"%{$request->search}%")
                  ->orWhere('test_name','like',"%{$request->search}%");
        }
        if ($request->status) $query->where('status', $request->status);
        $tests = $query->latest()->paginate(15)->withQueryString();
        $stats = [
            'total'       => LabTest::count(),
            'requested'   => LabTest::where('status','requested')->count(),
            'in_progress' => LabTest::where('status','in_progress')->count(),
            'completed'   => LabTest::where('status','completed')->count(),
        ];
        return view('lab.index', compact('tests','stats'));
    }

    public function create()
    {
        $patients = Patient::where('status','active')->get();
        $doctors  = Doctor::with('user')->get();
        return view('lab.create', compact('patients','doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id'        => 'required|exists:patients,id',
            'doctor_id'         => 'required|exists:doctors,id',
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'test_name'         => 'required|string',
            'test_type'         => 'required|string',
            'instructions'      => 'nullable|string',
            'price'             => 'required|numeric|min:0',
        ]);

        $test = LabTest::create($data);
        AuditLog::record('Lab Test Requested', $test);
        return redirect()->route('lab.show', $test)->with('success', 'Lab test requested.');
    }

    public function show(LabTest $lab)
    {
        $lab->load(['patient','doctor.user','medicalRecord']);
        return view('lab.show', compact('lab'));
    }

    public function update(Request $request, LabTest $lab)
    {
        $data = $request->validate([
            'status'       => 'required|in:requested,in_progress,completed,cancelled',
            'result'       => 'nullable|string',
            'instructions' => 'nullable|string',
        ]);

        if ($request->hasFile('report_file')) {
            $data['report_file'] = $request->file('report_file')->store('lab/reports','public');
        }
        if ($data['status'] === 'completed') $data['completed_at'] = now();

        $lab->update($data);
        AuditLog::record('Lab Test Updated', $lab);
        return redirect()->route('lab.show', $lab)->with('success', 'Lab test updated.');
    }
}
