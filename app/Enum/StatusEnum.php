<?php

namespace App\Enum;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return __('status.' . $this->value); 
    }

    public function badge(): string
    {
        return match($this) {
            self::PENDING => 'bg-label-warning',
            self::APPROVED => 'bg-label-success',
            self::REJECTED => 'bg-label-danger',
        };
    }
}
