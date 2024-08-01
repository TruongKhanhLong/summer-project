<?php

namespace App\Enums;

enum OrderStatus: int
{
    case NEW_ORDER = 1;
    case DONE_ORDER = 2;

    case TRANSPORTING = 3;

    case NOT_CREATED = 4;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}