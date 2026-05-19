<?php

namespace App\Rules;

use App\Models\Service;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsMyService implements ValidationRule
{
    protected Service $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if ($this->service->businessAccount->user_id === auth('api')->id()) {
            $fail('You can not request a service that you own.');
        }
    }
}
