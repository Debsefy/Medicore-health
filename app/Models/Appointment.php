<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'appointment_number','patient_id','doctor_id','appointment_date',
        'appointment_time','type','status','reason','notes','booked_by'
    ];

    protected $casts = ['appointment_date' => 'date', 'appointment_time' => 'datetime:H:i'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->appointment_number = 'APT-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);
        });
    }

    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function medicalRecord() { return $this->hasOne(MedicalRecord::class); }
    public function invoice() { return $this->hasOne(Invoice::class); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'confirmed' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show'   => 'secondary',
            default     => 'secondary',
        };
    }
}
