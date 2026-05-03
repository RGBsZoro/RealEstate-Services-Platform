<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'service_id',
        'client_id',
        'provider_id',
        'last_message_at',
    ];

    public function casts()
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }


    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
