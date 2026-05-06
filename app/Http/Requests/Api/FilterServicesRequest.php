<?php

namespace App\Http\Requests\Api;

use App\Enum\StatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterServicesRequest extends FormRequest
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
            'search'      => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'type'        => ['nullable', 'string', 'max:50'],
            'min_price'   => ['nullable', 'numeric', 'min:0'],
            'max_price'   => ['nullable', 'numeric', 'gte:min_price'],
            'sort_by'     => ['nullable', 'string', 'in:created_at,price_usd,title'],
            'sort_dir'    => ['nullable', 'string', 'in:asc,desc'],
            'status'      => ['nullable', Rule::enum(StatusEnum::class)],
            'per_page'    => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
