<?php

namespace App\Models;

use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'business_account_id',
        'category_id',
        'title',
        'description',
        'quantity',
        'type',
        'price_syp',
        'price_usd',
        'currency',
        'latitude',
        'longitude',
        'current_step',
        'status'
    ];

    public function casts()
    {
        return [
            'status' => StatusEnum::class,
        ];
    }

    public function businessAccount()
    {
        return $this->belongsTo(BusinessAccount::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function fieldValues()
    {
        return $this->hasMany(ServiceFieldValue::class);
    }

    public function requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
