<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = [
        'name','generic_name','category','manufacturer','unit','purchase_price',
        'selling_price','stock_quantity','minimum_stock','expiry_date','batch_number',
        'description','is_active'
    ];

    protected $casts = [
        'expiry_date'    => 'date',
        'is_active'      => 'boolean',
        'purchase_price' => 'decimal:2',
        'selling_price'  => 'decimal:2',
    ];

    public function isLowStock(): bool { return $this->stock_quantity <= $this->minimum_stock; }
    public function isExpired(): bool { return $this->expiry_date && $this->expiry_date->isPast(); }
    public function isExpiringSoon(): bool
    {
        return $this->expiry_date && $this->expiry_date->isFuture()
            && $this->expiry_date->diffInDays(now()) <= 30;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) return 'out_of_stock';
        if ($this->isLowStock()) return 'low_stock';
        return 'in_stock';
    }

    public function getStockStatusColorAttribute(): string
    {
        return match($this->stock_status) {
            'out_of_stock' => 'danger',
            'low_stock'    => 'warning',
            default        => 'success',
        };
    }
}
