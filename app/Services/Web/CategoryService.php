<?php

namespace App\Services\Web;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
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

      if (isset($data['icon'])) {
        $category->clearMediaCollection('Categories');
        $category->addMedia($data['icon'])->toMediaCollection('Categories');
      }
    });
  }
}
