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
 * @property ?string $account_number
 * @property int $value
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class DeclarationDeposit extends AbstractDeclarationOwnerPosition
{
    use HasFactory;

    protected $fillable = [
        'declaration_id',
        'owner',
        'name',
        'account_number',
        'value',
    ];
}
