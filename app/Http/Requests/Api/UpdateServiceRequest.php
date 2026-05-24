<?php

namespace App\Http\Requests\Api;

use App\Enum\FieldTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->service);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $customRules = [];

        $service = $this->service;

        $dynamicFields = $service->category
            ->allDynamicFields();

        $allowedFieldIds = $dynamicFields
            ->pluck('id')
            ->toArray();

        $fieldIndexes = collect($this->input('fields', []))
            ->mapWithKeys(
                fn($item, $index) => [
                    $item['id'] ?? null => $index
                ]
            );

        foreach ($dynamicFields as $dynamicField) {

            $fieldId = $dynamicField->id;

            if (!$fieldIndexes->has($fieldId)) {
                continue;
            }

            $rules = ['sometimes'];

            switch ($dynamicField->type) {

                case FieldTypeEnum::NUMBER:
                    $rules[] = 'numeric';
                    break;

                case FieldTypeEnum::DATE:
                    $rules[] = 'date';
                    break;

                case FieldTypeEnum::SELECT:

                    if (!empty($dynamicField->options)) {
                        $rules[] = Rule::in($dynamicField->options);
                    }

                    break;

                default:
                    $rules[] = 'string';
                    break;
            }

            $customRules['fields.' . $fieldIndexes[$fieldId] . '.value'] = $rules;
        }

        return array_merge([

            'title' => ['sometimes', 'string', 'max:255'],

            'description' => ['sometimes', 'string'],

            'quantity' => ['nullable', 'integer', 'min:1'],

            'price_syp' => ['sometimes', 'numeric', 'min:0'],

            'price_usd' => ['sometimes', 'numeric', 'min:0'],

            'type' => ['sometimes', 'in:sale,rent'],

            'latitude' => ['sometimes', 'numeric', 'between:-90,90'],

            'longitude' => ['sometimes', 'numeric', 'between:-180,180'],

            'main_image' => [
                'sometimes',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:4096'
            ],

            'gallery' => ['sometimes', 'array', 'max:5'],

            'gallery.*' => [
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:4096'
            ],

            'fields' => ['sometimes', 'array'],

            'fields.*.id' => [
                'required_with:fields',
                'integer',
                Rule::in($allowedFieldIds),
            ],

        ], $customRules);
    }
}
