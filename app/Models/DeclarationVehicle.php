<?php

namespace App\Models;

use App\Types\OwnerType;

/**
 * @property int $id
 * @property int $declaration_id
 * @property OwnerType $owner
 * @property string $description
 * @property int $value
 */
class DeclarationVehicle extends AbstractDeclarationOwnerAsset
{
    protected $fillable = ['declaration_id', 'owner', 'description', 'value'];
}
