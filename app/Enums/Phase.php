<?php

namespace App\Enums;

enum Phase: int
{
    case TRIAL = 1;
    case ACTIVE = 2;
    case SUSPENDED = 3;
    case CANCELED = 4;

    public function label(): string
    {
        return match ($this) {
            self::TRIAL => 'Trial',
            self::ACTIVE => 'Active',
            self::SUSPENDED => 'Suspended',
            self::CANCELED => 'Canceled',
        };
    }
}