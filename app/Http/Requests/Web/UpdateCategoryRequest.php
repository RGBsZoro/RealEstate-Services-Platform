<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name.*' => ['sometimes', 'array'],
            'name.en' => ['sometimes', 'string', 'unique:categories,name->en' . $this->category->id],
            'name.ar' => ['sometimes', 'string', 'unique:categories,name->ar' . $this->category->id],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'isActive' => ['sometimes', 'boolean'],
            'icon' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg']
        ];
    }
}
