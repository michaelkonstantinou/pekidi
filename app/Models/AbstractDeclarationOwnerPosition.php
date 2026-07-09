<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Model;

/**
 * The class holds every item (asset or liability) associated with a Declaration
 *
 * @property int $declaration_id
 * @property OwnerType $owner
 */
class AbstractDeclarationOwnerPosition extends Model
{
    protected $casts = ['owner' => OwnerType::class];
}
