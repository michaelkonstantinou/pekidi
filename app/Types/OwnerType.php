<?php

namespace App\Types;

enum OwnerType: string
{
    case Self = 'self';
    case Spouse = 'spouse';

    // Please note: An user can have multiple children... but they are all handled as one in assets declaration
    case Child = 'child';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
