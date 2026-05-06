<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Api\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $category) {}

    public function mainCategories()
    {
        $categories = $this->category->getMainCategories();

        return successResponse(CategoryResource::collection($categories));
    }

    public function subCategories(Category $category)
    {
        $categories = $this->category->getSubCategories($category);

        return successResponse(CategoryResource::collection($categories));
    }
}
