<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreServiceStep2Request extends FormRequest
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
        return [
            'title'      => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'quantity'   => 'required|integer|min:1',
            'type'       => 'required|in:sale,rent',
            'price_syp'  => 'required|numeric|min:0',
            'price_usd'  => 'required|numeric|min:0',
        ];
    }
}
