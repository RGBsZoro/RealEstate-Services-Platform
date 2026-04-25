<?php

namespace App\Enum;

enum ReportStatusEnum: string
{
    case Pending = 'pending';
    case Resolved = 'resolved';

    public function label(): string
    {
        return __('status.' . $this->value);
    }
}
