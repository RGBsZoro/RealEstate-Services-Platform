<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name.*' => ['required', 'array'],
            'name.en' => ['required', 'string', 'unique:categories,name->en'],
            'name.ar' => ['required', 'string', 'unique:categories,name->ar'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'isActive' => ['sometimes', 'boolean'],
            'icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg']
        ];
    }
}
