<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->service);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'quantity'    => ['nullable', 'integer', 'min:1'],
            'price_syp'   => ['sometimes', 'numeric', 'min:0'],
            'price_usd'   => ['sometimes', 'numeric', 'min:0'],
            'type'        => ['sometimes', 'string', 'max:50'],
            'latitude'    => ['sometimes', 'numeric', 'between:-90,90'],
            'longitude'   => ['sometimes', 'numeric', 'between:-180,180'],
            'main_image'  => ['sometimes', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'gallery'     => ['sometimes', 'array'],
            'gallery.*'   => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'fields'          => ['sometimes', 'array'],
            'fields.*.id'     => ['required_with:fields', 'integer', 'exists:dynamic_fields,id'],
            'fields.*.value'  => ['required_with:fields', 'string'],
        ];
    }
}
