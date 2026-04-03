<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueBusinessAccountPerActivity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function __construct(private ?int $ignoreId = null){}
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        auth('api')->user()->businessAccounts()
            ->where('activity_id', $value)
            ->when($this->ignoreId, fn($q) => $q->where('id', '!=', $this->ignoreId))
            ->exists() && $fail('You already have a business account for this activity.');
    }
}
