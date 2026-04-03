<?php

namespace App\Http\Requests;

use App\Models\BusinessAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreBusinessAccountStep2Request extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'license_number' => 'required',
            'name' => 'required|array',
            'name.ar' => 'required',
            'name.en' => 'required',
            'activities' => 'required',
            'details' => 'nullable'
        ];
    }
}
