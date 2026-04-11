<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = [
        'admin_id',
        'fcm_token',
        'device_type'
    ];

    public function tokenable(){
        return $this->morphTo();
    }
}
