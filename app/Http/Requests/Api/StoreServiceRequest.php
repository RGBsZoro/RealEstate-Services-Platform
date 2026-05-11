<?php

namespace App\Http\Requests\Api;

use App\Rules\HasSubCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enum\FieldTypeEnum;
use App\Models\DynamicField;

class StoreServiceRequest extends FormRequest
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
        $customRules = [];

        if ($this->has('fields')) {
            $fieldIds = collect($this->fields)->pluck('id')->filter()->toArray();
            $dynamicFields = DynamicField::whereIn('id', $fieldIds)->get()->keyBy('id');

            foreach ($this->fields as $index => $fieldData) {
                $fieldId = $fieldData['id'] ?? null;
                $dynamicField = $dynamicFields->get($fieldId);

                if ($dynamicField) {
                    $fieldRules = [$dynamicField->is_required ? 'required' : 'nullable'];

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
                    $customRules["fields.{$index}.value"] = $fieldRules;
                }
            }
        }

        $mainRules = [
            'fields'              => 'required|array',
            'fields.*.id'         => 'required|integer|exists:dynamic_fields,id',
            'business_account_id' => [
                'required',
                Rule::exists('business_accounts', 'id')->where(
                    fn($q) =>
                    $q->where('user_id', $this->user()->id)->where('status', 'approved')
                ),
            ],
            'category_id' => ['required', 'exists:categories,id,isActive,1', new HasSubCategory()],
            'title'      => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'quantity'   => 'nullable|integer|min:1',
            'type'       => 'required|in:sale,rent',
            'price_syp'  => 'required|numeric|min:0',
            'price_usd'  => 'required|numeric|min:0',
            'main_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'gallery'    => 'nullable|array|max:5',
            'gallery.*'  => 'image|mimes:jpg,jpeg,png|max:2048',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
        ];

        return array_merge($mainRules, $customRules);
    }
}
