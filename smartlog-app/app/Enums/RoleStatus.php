<?php

namespace App\Enums;

enum Role_ID: int
{
    case SA = 1;
    case MO = 2;
    case SP = 3;
    case OP = 4;
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

enum Role_level: int
{
    case A = 1;

    case B = 2;

    case C = 3;

    case D = 4;
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
