<?php

namespace App\Http\Requests\Web;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|array',
            'description' => 'nullable|array',

            'title.ar' => 'required_with:title.en|nullable|string|max:255',
            'title.en' => 'required_with:title.ar|nullable|string|max:255',

            'description.ar' => 'required_with:description.en|nullable|string',
            'description.en' => 'required_with:description.ar|nullable|string',

            'image' => $this->isMethod('POST') ? 'required|image|mimes:jpeg,png,jpg,webp|max:4048' : 'nullable|image|mimes:jpeg,png,jpg,webp|max:4048',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'sliderable_type' => 'nullable|string',
            'sliderable_id' => 'nullable|integer',
            'is_active' => 'boolean'
        ];
    }
}
