<?php

namespace App\Http\Requests\Api;

use App\Enum\FieldTypeEnum;
use App\Models\DynamicField;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class StoreServiceStep4Request extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'fields'     => 'required|array',
            'fields.*.id' => 'required|exists:dynamic_fields,id',
        ];

        if ($this->has('fields')) {
            foreach ($this->fields as $index => $fieldData) {
                $fieldId = $fieldData['id'] ?? null;
                if ($fieldId) {
                    $dynamicField = DynamicField::find($fieldId);
                    if (!$dynamicField) continue;

                    $fieldRules = [];

                    // 1. فحص هل الحقل مطلوب بناءً على إعدادات الأدمن
                    $fieldRules[] = $dynamicField->is_required ? 'required' : 'nullable';

                    // 2. فحص النوع بناءً على الـ Enum
                    switch ($dynamicField->type) { // الحقل type بالداتابيز مربوط بالـ Enum
                        case FieldTypeEnum::NUMBER:
                            $fieldRules[] = 'numeric';
                            break;
                        case FieldTypeEnum::DATE:
                            $fieldRules[] = 'date';
                            break;
                        case FieldTypeEnum::SELECT:
                            $fieldRules[] = 'string';
                            // فحص إن القيمة المرسلة موجودة ضمن الخيارات اللي حطها الأدمن
                            if (!empty($dynamicField->options)) {
                                $fieldRules[] = Rule::in($dynamicField->options);
                            }
                            break;
                        case FieldTypeEnum::TEXT:
                        case FieldTypeEnum::TEXTAREA:
                        default:
                            $fieldRules[] = 'string';
                            break;
                    }

                    $rules["fields.{$index}.value"] = $fieldRules;
                }
            }
        }

        return $rules;
    }
}
