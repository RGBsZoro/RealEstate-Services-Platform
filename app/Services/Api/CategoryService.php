<?php

namespace App\Services\Api;

use App\Models\Category;

class CategoryService
{
    public function getMainCategories()
    {
        return Category::whereNull('parent_id')
            ->where('isActive', true)
            ->orderBy('name')
            ->get();
    }

    public function getSubCategories(Category $category)
    {
        return $category->children()
            ->where('isActive', true)
            ->orderBy('name')
            ->get();
    }
}
