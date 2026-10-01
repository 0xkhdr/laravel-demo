<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'timezone' => 'UTC',
        'email_notifications' => true,
        'marketing_notifications' => false,
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'timezone' => 'string',
            'email_notifications' => 'boolean',
            'marketing_notifications' => 'boolean',
        ];
    }

    public function activityEvents(): HasMany
    {
        return $this->hasMany(UserActivityEvent::class);
    }
}
