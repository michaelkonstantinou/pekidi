<?php

namespace App\Types;

enum OwnerType: string
{
    case Self = 'self';
    case Spouse = 'spouse';
    case Child = 'child';
}
