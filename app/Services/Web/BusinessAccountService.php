<?php

namespace App\Services\Web;

use App\Models\BusinessAccount;
use App\Notifications\BusinessAccountStatusNotification;
use Illuminate\Validation\ValidationException;

class BusinessAccountService
{
    public function actions(BusinessAccount $businessAccount, $newStatus)
    {
        if ($businessAccount->status->value != 'pending')
            throw ValidationException::withMessages([
                'status' => ['Only pending services can be approved or rejected.']
            ]);

        // send notification
        $businessAccount->user->notify(new BusinessAccountStatusNotification($businessAccount));

        $businessAccount->update(['status' => $newStatus]);
    }
}
