<?php

namespace App\Rules;

use App\Models\Service;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckServiceQuantity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $service_id;
    public function __construct($service_id)
    {
        $this->service_id = $service_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $service = Service::find($this->service_id);

        if ($service && $value > $service->quantity)
            $fail('The requested quantity exceeds the available quantity ({$service->quantity}).');
    }
}
