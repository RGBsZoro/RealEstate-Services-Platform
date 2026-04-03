<?php

namespace App\Services\Web;

use App\Models\BusinessAccount;
use DragonCode\Support\Concerns\Validation;
use Illuminate\Validation\ValidationException;

class BusinessAccountService
{
    public function actions(BusinessAccount $businessAccount, $newStatus)
    {
        // dd($businessAccount->status, $newStatus);
        if ($businessAccount->status->value != 'pending')
            throw ValidationException::withMessages([
                'status' => ['Only pending accounts can be approved or rejected.']
            ]);

        $businessAccount->update(['status' => $newStatus]);
    }
}
