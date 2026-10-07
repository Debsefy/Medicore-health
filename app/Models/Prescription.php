<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'medical_record_id','patient_id','doctor_id','prescription_number','medications','notes','status'
    ];

    protected $casts = ['medications' => 'array'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->prescription_number = 'RX-' . date('Ymd') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function medicalRecord() { return $this->belongsTo(MedicalRecord::class); }
}
