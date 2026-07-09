<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $declaration_id
 * @property OwnerType $owner
 * @property string $name
 * @property string $business_type
 * @property string $involvement_type
 * @property int $value
 */
class DeclarationBusiness extends AbstractDeclarationOwnerAsset
{
    protected $fillable = ['declaration_id', 'owner', 'name', 'business_type', 'involvement_type', 'value'];
}
