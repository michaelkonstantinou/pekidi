<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $declaration_id
 * @property OwnerType $owner
 * @property string $creditor_name
 * @property string debt_type
 * @property int $value
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class DeclarationDebt extends AbstractDeclarationOwnerPosition
{
    use HasFactory;

    protected $casts = ['owner' => OwnerType::class];
    protected $fillable = [
        'declaration_id',
        'owner',
        'creditor_name',
        'debt_type',
        'value',
    ];
}
