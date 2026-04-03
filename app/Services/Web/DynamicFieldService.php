<?php

namespace App\Services\Web;

use App\Models\Category;
use App\Models\DynamicField;

class DynamicFieldService
{
    public function store(array $data, Category $category)
    {
        $category->dynamicFields()->create([
            'label' => $data['label'],
            'type' => $data['type'],
            'is_required' => $data['is_required'] ?? false,
            'options' => $data['options'] ?? null,
        ]);
    }

    public function udpate(array $data, DynamicField $dynamicField)
    {
        $dynamicField->update([
            'label' => $data['label'],
            'type' => $data['type'],
            'is_required' => $data['is_required'] ?? false,
            'options' => $data['options'] ?? null,
        ]);
    }

    public function destroy(DynamicField $dynamicField)
    {
        $dynamicField->delete();
    }
}
