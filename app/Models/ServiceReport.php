<?php

namespace App\Models;

use App\Enum\ReportStatusEnum;
use Illuminate\Database\Eloquent\Model;

class ServiceReport extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'reason',
        'status',
        'description'
    ];

    protected $casts = [
        'status' => ReportStatusEnum::class,
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
