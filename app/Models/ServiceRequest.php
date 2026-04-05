<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'requester_business_account_id',
        'user_id',
        'provider_business_account_id',
        'service_id',
        'required_at',
        'quantity',
        'details',
        'status',
        'price_usd_at_request',
        'price_syp_at_request'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function requesterBusinessAccount()
    {
        return $this->belongsTo(BusinessAccount::class, 'requester_business_account_id');
    }

    public function providerBusinessAccount()
    {
        return $this->belongsTo(BusinessAccount::class, 'provider_business_account_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
