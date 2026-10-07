<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientApiController extends Controller
{
    public function index(Request $request)
    {
        $patients = Patient::when($request->search, fn($q) =>
            $q->where('first_name', 'like', "%{$request->search}%")
              ->orWhere('last_name', 'like', "%{$request->search}%")
        )->paginate(20);

        return response()->json($patients);
    }

    public function show(Patient $patient)
    {
        return response()->json($patient->load('medicalRecords', 'appointments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'phone'         => 'required',
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:male,female,other',
        ]);

        return response()->json(Patient::create($data), 201);
    }

    public function update(Request $request, Patient $patient)
    {
        $patient->update($request->all());
        return response()->json($patient);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->json(null, 204);
    }
}
