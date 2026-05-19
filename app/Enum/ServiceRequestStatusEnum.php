<?php

namespace App\Enum;

enum ServiceRequestStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
    case EXPIRED = 'expired'; 
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return __('status.' . $this->value);
    }
}
