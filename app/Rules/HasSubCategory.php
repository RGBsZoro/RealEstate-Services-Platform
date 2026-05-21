<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasSubCategory implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $category = Category::withCount('children')->find($value);

        if (!$category) {
            $fail(__('validation.exists', ['attribute' => $attribute]));
            return;
        }

        if (!$category->isActive) {
            $fail(__('validation.category_inactive'));
            return; 
        }

        if ($category->children_count > 0) {
            $fail(__('validation.must_choose_subcategory'));
        }
    }
}
