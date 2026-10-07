<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number','patient_id','appointment_id','subtotal','tax','discount',
        'total','payment_method','status','due_date','paid_at','transaction_ref','notes'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at'  => 'datetime',
        'subtotal' => 'decimal:2',
        'tax'      => 'decimal:2',
        'discount' => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->invoice_number = 'INV-' . date('Y') . '-' . str_pad(static::count() + 1, 5, '0', STR_PAD_LEFT);
        });
    }

    public function patient()     { return $this->belongsTo(Patient::class); }
    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function items()       { return $this->hasMany(InvoiceItem::class); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'paid'      => 'success',
            'overdue'   => 'danger',
            'sent'      => 'primary',
            'draft'     => 'secondary',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }
}
