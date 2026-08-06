<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $declaration_id
 * @property OwnerType $owner
 * @property string $description
 * @property int $value
 */
class DeclarationVehicle extends AbstractDeclarationOwnerPosition
{
    use HasFactory;

    protected $fillable = ['declaration_id', 'owner', 'description', 'value'];
}
