<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordApiController extends Controller
{
    public function index(Request $request)
    {
        $records = MedicalRecord::with(['patient', 'doctor.user'])
            ->when($request->patient_id, fn($q) => $q->where('patient_id', $request->patient_id))
            ->latest('visit_date')
            ->paginate(20);

        return response()->json($records);
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return response()->json(
            $medicalRecord->load('patient', 'doctor.user', 'prescriptions')
        );
    }
}
