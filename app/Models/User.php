<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'avatar', 'is_active', 'last_login_at'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'is_active'         => 'boolean',
        'password'          => 'hashed',
    ];

    // Role checks
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isDoctor(): bool { return $this->role === 'doctor'; }
    public function isNurse(): bool { return $this->role === 'nurse'; }
    public function isReceptionist(): bool { return $this->role === 'receptionist'; }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) return in_array($this->role, $roles);
        return $this->role === $roles;
    }

    // Relationships
    public function doctor() { return $this->hasOne(Doctor::class); }
    public function notifications() { return $this->hasMany(SystemNotification::class); }
    public function auditLogs() { return $this->hasMany(AuditLog::class); }
    public function unreadNotifications() { return $this->notifications()->where('is_read', false); }

    public function getRoleColorAttribute(): string
    {
        return match($this->role) {
            'admin'         => 'danger',
            'doctor'        => 'primary',
            'nurse'         => 'success',
            'receptionist'  => 'warning',
            default         => 'secondary',
        };
    }

    public function getRoleBadgeAttribute(): string
    {
        return '<span class="badge badge-' . $this->role_color . '">' . ucfirst($this->role) . '</span>';
    }
}
