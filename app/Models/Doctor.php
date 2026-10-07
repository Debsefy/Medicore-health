<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id','doctor_id','specialization','qualification','experience_years',
        'license_number','consultation_fee','available_days','available_from',
        'available_to','bio','is_available'
    ];

    protected $casts = [
        'available_days' => 'array',
        'is_available'   => 'boolean',
        'consultation_fee' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->doctor_id = 'DOC-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function user() { return $this->belongsTo(User::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function medicalRecords() { return $this->hasMany(MedicalRecord::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
    public function labTests() { return $this->hasMany(LabTest::class); }

    public function getNameAttribute(): string { return $this->user->name ?? 'Unknown'; }
    public function getEmailAttribute(): string { return $this->user->email ?? ''; }
}
