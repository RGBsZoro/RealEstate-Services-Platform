<?php

namespace App\Http\Requests\Api;

use App\Models\Service;
use App\Rules\CheckServiceQuantity;
use App\Rules\IsMyService;
use App\Rules\ServiceNotBooked;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateServiceRequestOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->serviceRequest);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $service = Service::find($this->serviceRequest->service_id);
        $isQuantityRequired = $service && !is_null($service->quantity);

        return [

            'requester_business_account_id' => [
                'required',
                Rule::exists('business_accounts', 'id')->where(function ($query) {
                    $query->where('user_id', $this->user()->id)
                        ->where('status', 'approved');
                }),
            ],

            'required_at' => ['required', 'date_format:Y-m-d H:i', 'after_or_equal:today', $service ? new ServiceNotBooked($service, $this->serviceRequest->id) : 'nullable'],
            'quantity'    => [$isQuantityRequired ? 'required' : 'nullable', 'integer', 'min:1', $service ? new CheckServiceQuantity($service) : 'nullable'],
            'details'     => 'nullable|string|max:2000',

        ];
    }
}
