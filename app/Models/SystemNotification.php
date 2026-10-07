<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
    protected $table = 'system_notifications';

    protected $fillable = [
        'user_id','title','message','type','icon','is_read','action_url'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function send(
        int $userId,
        string $title,
        string $message,
        string $type = 'info',
        string $icon = null,
        string $url  = null
    ): void {
        static::create([
            'user_id'    => $userId,
            'title'      => $title,
            'message'    => $message,
            'type'       => $type,
            'icon'       => $icon ?? match($type) {
                'success' => 'fa-check-circle',
                'warning' => 'fa-exclamation-triangle',
                'danger'  => 'fa-times-circle',
                default   => 'fa-info-circle',
            },
            'action_url' => $url,
        ]);
    }
}
