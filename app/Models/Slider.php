<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Slider extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    public array $translatable = ['title', 'description'];

    protected $fillable = [
        'title',
        'description',
        'sliderable_id',
        'sliderable_type',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function casts()
    {
        return
            [
                'start_date' => 'datetime',
                'end_date' => 'datetime',
                'is_active' => 'boolean',
            ];
    }

    public function sliderable()
    {
        return $this->morphTo();
    }
}
