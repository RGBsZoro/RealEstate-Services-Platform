<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = [
        'phone',
        'otp',
        'type',
        'expires_at',
        'is_used',
        'session_id',
        'attempts'
    ];

    protected function casts(): array
    {
        return [
            'otp' => 'hashed',
        ];
    }
}
