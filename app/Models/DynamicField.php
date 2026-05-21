<?php

namespace App\Models;

use App\Enum\FieldTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DynamicField extends Model
{
    use HasTranslations;
    public array $translatable = ['label'];

    protected $fillable = [
        'label',
        'type',
        'options',
        'is_required',
        'category_id'
    ];

    public function casts()
    {
        return [
            'options' => 'array',
            'type' => FieldTypeEnum::class
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
