<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;
    public array $translatable = ['name'];

    protected $fillable = [
        'name',
        'parent_id',
        'isActive'
    ];

    public function allDynamicFields()
    {
        $fields = $this->dynamicFields;
        if ($this->parent_id) {
            $fields = $fields->merge($this->parent()->first()->dynamicFields);
        }
        return $fields;
    }

    public function dynamicFields()
    {
        return $this->hasMany(DynamicField::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
