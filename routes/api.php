<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthApiController,
    PatientApiController,
    DoctorApiController,
    AppointmentApiController,
    MedicalRecordApiController,
    InvoiceApiController
};

Route::post('/auth/login',  [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);
    Route::get('/auth/me',      [AuthApiController::class, 'me']);

    Route::apiResource('patients',       PatientApiController::class);
    Route::apiResource('doctors',        DoctorApiController::class)->only(['index','show']);
    Route::apiResource('appointments',   AppointmentApiController::class);
    Route::apiResource('medical-records',MedicalRecordApiController::class)->only(['index','show']);
    Route::apiResource('invoices',       InvoiceApiController::class)->only(['index','show']);
});
