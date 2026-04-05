<?php

namespace App\Http\Requests\Api;

use App\Rules\HasSubCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreServiceStep1Request extends FormRequest
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
        return [
            'business_account_id' => [
                'required',
                Rule::exists('business_accounts', 'id')->where(function ($query) {
                    $query->where('user_id', $this->user()->id)
                        ->where('status', 'approved');
                }),
            ],
            'category_id' => ['required', 'exists:categories,id,isActive,1', new HasSubCategory()],
        ];
    }
}
