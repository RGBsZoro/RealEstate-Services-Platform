<?php

namespace App\Http\Requests\Api;

use App\Models\Service;
use App\Rules\CheckServiceQuantity;
use App\Rules\IsMyService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequestOrder extends FormRequest
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
        $service = Service::find($this->service_id);
        $isQuantityRequired = $service && !is_null($service->quantity);

        return [

            'requester_business_account_id' => [
                'required',
                Rule::exists('business_accounts', 'id')->where(function ($query) {
                    $query->where('user_id', $this->user()->id)
                        ->where('status', 'approved');
                }),
            ],

            'service_id' => ['required', 'exists:services,id,status,approved', new IsMyService()],

            'required_at' => 'required|date|after_or_equal:today',
            'quantity'    => [$isQuantityRequired ? 'required' : 'nullable', 'integer', 'min:1', $service ? new CheckServiceQuantity($service) : 'nullable'],
            'details'     => 'nullable|string|max:2000',

        ];
    }
}
