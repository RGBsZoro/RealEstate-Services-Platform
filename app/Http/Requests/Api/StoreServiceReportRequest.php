<?php

namespace App\Http\Requests\Api;

use App\Models\Service;
use App\Rules\NotOwnService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceReportRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $service = $this->route('service');
        $this->merge([
            'service_id' => $service instanceof Service ? $service->id : $service,
        ]);
    }
    public function rules(): array
    {
        return [
            'service_id' => [
                'required',
                'exists:services,id,status,approved',
                new NotOwnService()
            ],
            'reason' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
