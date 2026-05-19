<?php

namespace App\Rules;

use App\Enum\ServiceRequestStatusEnum;
use App\Models\Service;
use App\Models\ServiceRequest;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ServiceNotBooked implements ValidationRule
{
    protected ?Service $service;
    public function __construct(Service $service, protected ?int $ignoreId = null)
    {
        $this->service = $service;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->service->requests()
            ->where('status', ServiceRequestStatusEnum::APPROVED->value)
            ->where('required_at', $value)
            ->when($this->ignoreId, fn($q) => $q->where('id', '!=', $this->ignoreId))
            ->exists() && $fail('This time slot is already booked.');
    }
}
