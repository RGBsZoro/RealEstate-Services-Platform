<?php

namespace App\Services\Web;

use App\Models\Service;
use Illuminate\Validation\ValidationException;

class ServiceManagementService
{
    public function actions(Service $service, $newStatus)
    {
        if ($service->status->value != 'pending')
            throw ValidationException::withMessages([
                'status' => ['Only pending accounts can be approved or rejected.']
            ]);

        $service->update(['status' => $newStatus]);
    }
}
