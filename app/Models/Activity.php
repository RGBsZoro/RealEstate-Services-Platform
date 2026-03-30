<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Activity extends Model implements HasMedia
{
    use HasTranslations , InteractsWithMedia;
    public array $translatable = ['name'];

    protected $fillable = [
        'name',
    ];
}
