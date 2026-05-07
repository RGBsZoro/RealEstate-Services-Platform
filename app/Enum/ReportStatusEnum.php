<?php

namespace App\Enum;

enum ReportStatusEnum: string
{
    case PENDING = 'pending';
    case RESOLVED = 'resolved';

    public function label(): string
    {
        return __('status.' . $this->value);
    }
}
