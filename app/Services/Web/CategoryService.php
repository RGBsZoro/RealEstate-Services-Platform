<?php

namespace App\Services\Web;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{

  public function index(array $data, bool $isMain = true)
  {
    $query = Category::query();

    if ($isMain) {
      $query->whereNull('parent_id')->withCount(['children', 'dynamicFields']);
    } else {
      $query->whereNotNull('parent_id')->with('parent')->withCount('dynamicFields');
    }

    if (!empty($data['search'])) {
      $search = $data['search'];
      $query->where(function ($q) use ($search) {
        $q->where('name->en', 'like', "%{$search}%")
          ->orWhere('name->ar', 'like', "%{$search}%");
      });
    }

    if (!empty($data['status'])) {
      $query->where('isActive', $data['status']);
    }

    if (!$isMain && !empty($data['parent_id'])) {
      $query->where('parent_id', $data['parent_id']);
    }

    $statsQuery = $isMain ? Category::whereNull('parent_id') : Category::whereNotNull('parent_id');

    $stats = [
      'total'    => (clone $statsQuery)->count(),
      'active'   => (clone $statsQuery)->where('isActive', 1)->count(),
      'inactive' => (clone $statsQuery)->where('isActive', 0)->count(),
    ];

    $mainCategories = !$isMain
      ? cache()->remember('main_categories_list', 3600, fn() => Category::whereNull('parent_id')->get())
      : null;

    return [
      'categories'     => $query->latest()->paginate($isMain ? 10 : 15),
      'stats'          => $stats,
      'mainCategories' => $mainCategories
    ];
  }

  public function store(array $data)
  {
    DB::transaction(function () use ($data) {
      $category = Category::create([
        'parent_id' => $data['parent_id'] ?? null,
        'name' => $data['name'],
        'isActive' => $data['isActive'] ?? false
      ]);

      if (isset($data['icon']))
        $category->addMedia($data['icon'])->toMediaCollection('Categories');
    });
  }

  public function update(array $data, Category $category)
  {
    DB::transaction(function () use ($data, $category) {
      $category->update([
        'parent_id' => $data['parent_id'] ?? null,
        'name' => $data['name'],
        'isActive' => $data['isActive'] ?? false
      ]);

      if ($category->wasChanged('isActive') && $category->isActive == false) {
        $category->children()->update(['isActive' => false]);
      }


      if (isset($data['icon'])) {
        $category->clearMediaCollection('Categories');
        $category->addMedia($data['icon'])->toMediaCollection('Categories');
      }
    });
  }
}
