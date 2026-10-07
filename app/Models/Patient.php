<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id','first_name','last_name','email','phone','date_of_birth',
        'gender','address','blood_type','allergies','emergency_contact_name',
        'emergency_contact_phone','status','photo'
    ];

    protected $casts = ['date_of_birth' => 'date'];

    public function getFullNameAttribute(): string { return "{$this->first_name} {$this->last_name}"; }
    public function getAgeAttribute(): int { return $this->date_of_birth->age; }

    public function appointments() { return $this->hasMany(Appointment::class); }
    public function medicalRecords() { return $this->hasMany(MedicalRecord::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
    public function labTests() { return $this->hasMany(LabTest::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active'   => 'success',
            'inactive' => 'warning',
            'deceased' => 'danger',
            default    => 'secondary',
        };
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->patient_id = 'PAT-' . date('Y') . str_pad(static::withTrashed()->count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}
