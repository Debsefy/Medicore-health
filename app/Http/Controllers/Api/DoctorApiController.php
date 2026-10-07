<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;

class DoctorApiController extends Controller
{
    public function index()
    {
        return response()->json(Doctor::with('user')->get());
    }

    public function show(Doctor $doctor)
    {
        return response()->json($doctor->load('user', 'appointments'));
    }
}
