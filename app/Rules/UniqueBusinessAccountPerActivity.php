<?php

namespace App\Rules;

use App\Enum\StatusEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueBusinessAccountPerActivity implements ValidationRule
{
    public function __construct(private ?int $ignoreId = null) {}
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        auth('api')->user()->businessAccounts()
            ->where('status', '!=', StatusEnum::REJECTED->value)
            ->where('activity_id', $value)
            ->when($this->ignoreId, fn($q) => $q->where('id', '!=', $this->ignoreId))
            ->exists() && $fail('You already have a business account for this activity.');
    }
}
