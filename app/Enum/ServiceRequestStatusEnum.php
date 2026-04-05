<?php

namespace App\Enum;

enum ServiceRequestStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return __('status.' . $this->value);
    }
}
