<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $declaration_id
 * @property OwnerType $owner
 * @property string $name
 * @property ?string $registration_number
 * @property ?string $country
 * @property int $quantity
 * @property ?string $acquisition_type
 * @property ?int $acquisition_year
 * @property int $value
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class DeclarationInvestment extends AbstractDeclarationOwnerPosition
{
    use HasFactory;

    protected $fillable = [
        'declaration_id',
        'owner',
        'name',
        'registration_number',
        'country',
        'quantity',
        'acquisition_type',
        'acquisition_year',
        'value',
    ];
}
