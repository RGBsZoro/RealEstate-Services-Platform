<?php

namespace App\Services\Web;

use App\Models\BusinessAccount;
use Illuminate\Validation\ValidationException;

class BusinessAccountService
{
    public function actions(BusinessAccount $businessAccount, $newStatus)
    {
        if ($businessAccount->status->value != 'pending')
            throw ValidationException::withMessages([
                'status' => ['Only pending services can be approved or rejected.']
            ]);

        $businessAccount->update(['status' => $newStatus]);
    }
}
