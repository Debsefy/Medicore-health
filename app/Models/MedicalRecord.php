<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id','doctor_id','appointment_id','visit_date','chief_complaint',
        'diagnosis','treatment_plan','notes','weight','height','blood_pressure',
        'temperature','pulse_rate'
    ];

    protected $casts = ['visit_date' => 'date'];

    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
    public function labTests() { return $this->hasMany(LabTest::class); }

    public function getBmiAttribute(): ?float
    {
        if ($this->weight && $this->height) {
            $heightM = $this->height / 100;
            return round($this->weight / ($heightM * $heightM), 1);
        }
        return null;
    }
}
