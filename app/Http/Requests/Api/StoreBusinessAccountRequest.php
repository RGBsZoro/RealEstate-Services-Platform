<?php

namespace App\Http\Requests\Api;

use App\Rules\UniqueBusinessAccountPerActivity;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBusinessAccountRequest extends FormRequest
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
            'activity_id' => ['required', 'exists:activities,id', new UniqueBusinessAccountPerActivity()],
            'license_number' => 'required',
            'name' => 'required|array',
            'name.ar' => [
                'required',
                Rule::unique('business_accounts', 'name->ar')->whereNot('status', 'rejected')
            ],
            'name.en' => [
                'required',
                Rule::unique('business_accounts', 'name->en')->whereNot('status', 'rejected')
            ],
            'activities' => 'required',
            'details' => 'nullable',
            'city_id' => 'required|exists:cities,id,is_active,1',
            'latitude' => 'required',
            'longitude' => 'required',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf|max:10048',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpg,jpeg,png|max:4048'
        ];
    }
}
