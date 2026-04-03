<?php

namespace App\Http\Requests\Web;

use App\Enum\FieldTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateDynamicFieldRequest extends FormRequest
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
            'type' => ['sometimes', new Enum(FieldTypeEnum::class)],
            'label.en' => 'sometimes|string',
            'label.ar' => 'sometimes|string',
            'is_sometimes' => 'sometimes|boolean',
            'options' => 'required_if:type,' . FieldTypeEnum::SELECT->value . '|array',
        ];
    }
}
