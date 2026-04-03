<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreCategoryRequest;
use App\Http\Requests\Web\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Web\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $category) {}

    public function indexMain()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('dashboard.categories.main.index', compact('categories'));
    }

    public function indexSub()
    {
        $categories = Category::whereNotNull('parent_id')->with('parent')->get();
        return view('dashboard.categories.sub.index', compact('categories'));
    }

    public function createMain()
    {
        return view('dashboard.categories.main.create');
    }

    public function createSub()
    {
        $mainCategories = Category::whereNull('parent_id')->get();
        return view('dashboard.categories.sub.create', compact('mainCategories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->category->store($request->validated());
        return redirect()->to($request->return_url);
    }

    public function edit(Category $category)
    {
        $mainCategories = Category::whereNull('parent_id')->get();
        return view('dashboard.categories.edit', compact('category','mainCategories'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->category->update($request->validated(), $category);
        return redirect()->to($request->return_url);
    }
}
