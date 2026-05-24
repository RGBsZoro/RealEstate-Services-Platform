<?php

namespace App\Http\Requests\Api;

use App\Enum\FieldTypeEnum;
use App\Models\Category;
use App\Rules\HasSubCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $customRules = [];
        $allowedFieldIds = [];

        $category = null;

        if ($this->filled('category_id')) {
            $category = Category::find($this->category_id);
        }

        if ($category && $this->has('fields')) {

            $dynamicFields = $category->allDynamicFields();

            $allowedFieldIds = $dynamicFields->pluck('id')->toArray();

            $userFields = collect($this->input('fields', []))
                ->keyBy('id');

            foreach ($dynamicFields as $dynamicField) {

                $fieldId = $dynamicField->id;

                $fieldRules = [
                    $dynamicField->is_required ? 'required' : 'nullable'
                ];

                switch ($dynamicField->type) {

                    case FieldTypeEnum::NUMBER:
                        $fieldRules[] = 'numeric';
                        break;

                    case FieldTypeEnum::DATE:
                        $fieldRules[] = 'date';
                        break;

                    case FieldTypeEnum::SELECT:

                        if (!empty($dynamicField->options)) {
                            $fieldRules[] = Rule::in($dynamicField->options);
                        }

                        break;

                    default:
                        $fieldRules[] = 'string';
                        break;
                }

                $userField = $userFields->get($fieldId);

                if ($userField) {

                    $index = collect($this->fields)
                        ->search(fn($field) => ($field['id'] ?? null) == $fieldId);

                    $customRules["fields.{$index}.value"] = $fieldRules;

                } elseif ($dynamicField->is_required) {

                    $customRules["fields_required_{$fieldId}"] = [
                        'required'
                    ];
                }
            }
        }

        return array_merge([

            'fields' => 'required|array',

            'fields.*.id' => [
                'required',
                'integer',
                Rule::in($allowedFieldIds),
            ],

            'business_account_id' => [
                'required',
                Rule::exists('business_accounts', 'id')
                    ->where(fn($q) => $q
                        ->where('user_id', $this->user()->id)
                        ->where('status', 'approved')
                    ),
            ],

            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where('isActive', 1),
                new HasSubCategory(),
            ],

            'title' => 'required|string|max:255',

            'description' => 'required|string|min:10',

            'quantity' => 'nullable|integer|min:1',

            'type' => 'required|in:sale,rent',

            'price_syp' => 'required|numeric|min:0',

            'price_usd' => 'required|numeric|min:0',

            'main_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',

            'gallery' => 'nullable|array|max:5',

            'gallery.*' => 'image|mimes:jpg,jpeg,png|max:2048',

            'latitude' => 'required|numeric|between:-90,90',

            'longitude' => 'required|numeric|between:-180,180',

        ], $customRules);
    }

    public function messages(): array
    {
        $messages = [

            'fields.required' => 'Fields are required.',

            'fields.array' => 'Fields must be an array.',

            'fields.*.id.in' => 'One or more selected fields are invalid.',
        ];

        if ($this->filled('category_id')) {

            $category = Category::find($this->category_id);

            if ($category) {

                foreach ($category->allDynamicFields() as $field) {

                    $messages["fields_required_{$field->id}.required"]
                        = "The field ({$field->label}) is required.";
                }
            }
        }

        return $messages;
    }
}