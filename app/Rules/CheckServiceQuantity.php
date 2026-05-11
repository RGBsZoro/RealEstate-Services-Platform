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
    protected ?Service $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->service || is_null($this->service->quantity)) {
            return;
        }

        if ($this->service && $value > $this->service->quantity)
            $fail('The requested quantity exceeds the available quantity ({$this->service->quantity}).');
    }
}
