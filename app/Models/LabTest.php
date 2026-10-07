<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    protected $fillable = [
        'test_number','patient_id','doctor_id','medical_record_id','test_name',
        'test_type','status','instructions','result','report_file','completed_at','price'
    ];

    protected $casts = ['completed_at' => 'datetime', 'price' => 'decimal:2'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->test_number = 'LAB-' . date('Ymd') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function medicalRecord() { return $this->belongsTo(MedicalRecord::class); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'requested'   => 'warning',
            'in_progress' => 'primary',
            'completed'   => 'success',
            'cancelled'   => 'danger',
            default       => 'secondary',
        };
    }
}
