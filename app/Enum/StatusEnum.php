<?php

namespace App\Enum;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return __('status.' . $this->value);
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING => 'bg-label-warning',
            self::APPROVED => 'bg-label-success',
            self::REJECTED => 'bg-label-danger',
            self::INACTIVE => 'bg-label-secondary',
        };
    }
}
