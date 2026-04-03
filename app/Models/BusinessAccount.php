<?php

namespace App\Models;

use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class BusinessAccount extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;
    public array $translatable = ['name'];

    protected $fillable = [
        'user_id',
        'activity_id',
        'license_number',
        'name',
        'activities',
        'details',
        'city_id',
        'latitude',
        'longitude',
        'status',
        'current_step'
    ];

    public function casts(){
        return [
            'status' => StatusEnum::class
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
