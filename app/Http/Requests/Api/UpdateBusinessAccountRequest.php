<?php

namespace App\Http\Requests\Api;

use App\Rules\UniqueBusinessAccountPerActivity;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateBusinessAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->businessAccount);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'activity_id' => ['sometimes', 'integer', 'exists:activities,id', new UniqueBusinessAccountPerActivity($this->businessAccount->id)],
            'name' => ['sometimes', 'array'],
            'name.ar' => [
                'required',
                Rule::unique('business_accounts', 'name->ar')->whereNot('status', 'rejected')
            ],
            'name.en' => [
                'required',
                Rule::unique('business_accounts', 'name->en')->whereNot('status', 'rejected')
            ],
            'license_number' => ['sometimes', 'string', 'max:255'],
            'activities' => ['sometimes', 'string'],
            'details' => ['nullable', 'string'],
            'city_id' => ['sometimes', 'integer', 'exists:cities,id'],
            'latitude' => ['sometimes', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'numeric', 'between:-180,180'],

            'documents' => ['sometimes', 'array'],
            'documents.*' => ['file', 'mimes:pdf,jpg,png', 'max:5120'],

            'images' => ['sometimes', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ];
    }
}
