<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $declaration_id
 * @property OwnerType $owner
 */
class AbstractDeclarationOwnerAsset extends Model
{
    protected $casts = ['owner' => OwnerType::class];
}
